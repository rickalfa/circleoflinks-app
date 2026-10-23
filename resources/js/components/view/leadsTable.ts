import ApiService from "../../core/ApiService";
import type {
    LeadAttentionStatus,
    LeadRow,
    PaginatedLeadsResponse,
    PaginationMeta,
} from "../../types/LeadTable";

/**
 * Servicio de comunicación con `/chat-api/*` para la tabla de Leads.
 */
class LeadsTableService extends ApiService {
    constructor() {
        super("/chat-api");
    }

    async fetchLeads(page: number, perPage: 5 | 10): Promise<PaginatedLeadsResponse> {
        const response = await this.get<PaginatedLeadsResponse>("/leads", {
            params: { page, per_page: perPage },
        });
        if (!response.data) {
            throw new Error("Respuesta vacía al cargar leads");
        }
        return response.data;
    }

    async takeControl(
        conversationId: number,
        action: "human_active" | "bot_active" = "human_active"
    ): Promise<boolean> {
        const response = await this.post<{ success: boolean }>("/take-control", {
            conversation_id: conversationId,
            action,
        });
        return Boolean(response.data?.success);
    }

    async convertToContact(leadId: number): Promise<boolean> {
        const response = await this.post<{ success: boolean }>(
            `/leads/${leadId}/convert-to-contact`
        );
        return Boolean(response.data?.success);
    }
}

/* ---------- Helpers de formato y seguridad XSS ---------- */

const MIN_MS = 60 * 1000;

const escapeHtml = (value: unknown): string =>
    String(value ?? "").replace(/[&<>"']/g, (char) => {
        const map: Record<string, string> = {
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#39;",
        };
        return map[char] ?? char;
    });

const truncate = (text: string | null | undefined, max: number): string => {
    if (!text) return "";
    return text.length > max ? text.slice(0, max - 1) + "…" : text;
};

const formatPhone = (phone: string | null | undefined): string => {
    if (!phone) return "—";
    const digits = phone.replace(/\D/g, "");
    if (digits.length === 11 && digits.startsWith("569")) {
        return `+${digits.slice(0, 2)} ${digits.slice(2, 3)} ${digits.slice(3, 7)} ${digits.slice(7)}`;
    }
    return `+${digits}`;
};

const timeAgo = (isoOrSqlDate: string | null | undefined): string => {
    if (!isoOrSqlDate) return "—";
    const parsed = new Date(isoOrSqlDate.replace(" ", "T")).getTime();
    if (Number.isNaN(parsed)) return isoOrSqlDate;

    const diffMin = Math.round((Date.now() - parsed) / MIN_MS);
    if (diffMin < 1) return "ahora";
    if (diffMin < 60) return `hace ${diffMin} min`;
    const hours = Math.round(diffMin / 60);
    if (hours < 24) return `hace ${hours} h`;
    return `hace ${Math.round(hours / 24)} d`;
};

const buildAvatarUrl = (lead: LeadRow): string => {
    if (lead.avatar_url) {
        return lead.avatar_url;
    }
    const encoded = encodeURIComponent(lead.name || "Lead");
    return `https://ui-avatars.com/api/?name=${encoded}&background=25D366&color=fff&size=96&bold=true`;
};

/* ---------- Mapa de estados de atención ---------- */

const STATUS_META: Record<
    LeadAttentionStatus,
    { cls: string; icon: string; label: string }
> = {
    WAITING_HUMAN: {
        cls: "text-bg-danger pulse",
        icon: "bi-person-raised-hand",
        label: "Solicita atención humana",
    },
    HUMAN_ACTIVE: {
        cls: "text-bg-warning",
        icon: "bi-headset",
        label: "Atendido por humano",
    },
    BOT_ACTIVE: {
        cls: "text-bg-success",
        icon: "bi-robot",
        label: "Atendido por el bot",
    },
    CLOSED: {
        cls: "text-bg-secondary",
        icon: "bi-check2-circle",
        label: "Conversación cerrada",
    },
    NO_CONVERSATION: {
        cls: "bg-body-secondary text-body-secondary",
        icon: "bi-dash-circle",
        label: "Sin conversación",
    },
};

/* ---------- Renderizado de las 3 columnas ---------- */

const renderLeadCell = (lead: LeadRow): string => {
    const avatar = buildAvatarUrl(lead);
    const fallbackAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(
        lead.name || "Lead"
    )}&background=25D366&color=fff&size=96&bold=true`;

    const hasUnread = lead.has_unread_messages || lead.unread_messages_count > 0;
    const countLabel =
        lead.unread_messages_count > 99
            ? "99+"
            : String(lead.unread_messages_count || 1);

    const unreadBadge = `<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light unread-badge" data-lead-id="${
        lead.id
    }" style="display: ${hasUnread ? "inline-block" : "none"};">${
        hasUnread ? countLabel : ""
    }<span class="visually-hidden">Mensajes no leídos</span></span>`;

    const exactDateTitle = lead.last_message_time
        ? escapeHtml(lead.last_message_time)
        : "Sin mensajes recientes";

    return `
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative flex-shrink-0">
                <img src="${escapeHtml(avatar)}"
                     class="rounded-circle avatar"
                     alt="Avatar de ${escapeHtml(lead.name)}"
                     onerror="this.onerror=null;this.src='${escapeHtml(fallbackAvatar)}';" />
                ${unreadBadge}
            </div>
            <div class="flex-grow-1 min-w-0">
                <div class="fw-semibold text-truncate">
                    <i class="bi bi-whatsapp me-1 wsp-icon"></i>${escapeHtml(lead.name)}
                </div>
                <div class="muted-xs">${escapeHtml(formatPhone(lead.phone_number))}</div>
                <div class="muted-xs" title="${exactDateTitle}">
                    <i class="bi bi-clock me-1"></i>Último mensaje ${escapeHtml(
                        timeAgo(lead.last_message_time)
                    )}
                </div>
            </div>
            <button type="button"
                    class="btn btn-primary btn-sm rounded-pill px-3 flex-shrink-0 btn-open-chat"
                    data-value="${lead.id}"
                    data-name="${escapeHtml(lead.name)}"
                    data-phone="${escapeHtml(lead.phone_number)}"
                    data-avatar="${escapeHtml(avatar)}"
                    data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop">
                <i class="bi bi-chat-dots-fill me-1"></i>Chat Live
            </button>
        </div>
    `;
};

const renderContactCell = (lead: LeadRow, contactsUrl: string): string => {
    const c = lead.contact;

    if (!c.is_contact) {
        return `
            <div class="contact-empty d-flex align-items-center justify-content-between gap-2">
                <div>
                    <div class="muted-xs"><i class="bi bi-person-dash me-1"></i>Aún no es contacto</div>
                    <span class="badge bg-body-secondary text-body-secondary fw-normal mt-1">${escapeHtml(
                        c.status_name || "no-registrado"
                    )}</span>
                </div>
                <button type="button"
                        class="btn btn-outline-success btn-sm rounded-pill btn-convert-contact"
                        data-lead-id="${lead.id}">
                    <i class="bi bi-person-plus me-1"></i>Convertir
                </button>
            </div>
        `;
    }

    return `
        <div class="contact-box">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="fw-semibold small text-truncate">${escapeHtml(
                    c.name || lead.name
                )}</span>
                <span class="badge rounded-pill badge-contact">
                    <i class="bi bi-person-check me-1"></i>Contacto
                </span>
            </div>
            <div class="muted-xs text-truncate">
                <i class="bi bi-envelope me-1"></i>${escapeHtml(c.email || "—")}
            </div>
            <div class="muted-xs">
                <i class="bi bi-telephone me-1"></i>${escapeHtml(
                    formatPhone(c.phone_number || lead.phone_number)
                )}
            </div>
            ${
                c.address
                    ? `<div class="muted-xs text-truncate"><i class="bi bi-geo-alt me-1"></i>${escapeHtml(
                          c.address
                      )}</div>`
                    : ""
            }
            <a href="${escapeHtml(
                contactsUrl
            )}" class="muted-xs link-success text-decoration-none d-inline-block mt-1">
                Ver ficha <i class="bi bi-arrow-right-short"></i>
            </a>
        </div>
    `;
};

const renderStatusCell = (lead: LeadRow): string => {
    const a = lead.attention;
    const meta = STATUS_META[a.status] ?? STATUS_META.NO_CONVERSATION;
    const avatar = buildAvatarUrl(lead);

    let sub = "";
    let action = "";

    if (a.status === "WAITING_HUMAN") {
        const waitText = a.since ? timeAgo(a.since).replace("hace ", "") : "unos instantes";
        sub = `<div class="small text-danger-emphasis mt-1"><i class="bi bi-hourglass-split me-1"></i>Esperando ${escapeHtml(
            waitText
        )}</div>`;

        if (a.conversation_id) {
            action = `
                <button type="button"
                        class="btn btn-danger btn-sm rounded-pill mt-2 btn-take-chat"
                        data-conversation-id="${a.conversation_id}"
                        data-lead-id="${lead.id}"
                        data-name="${escapeHtml(lead.name)}"
                        data-phone="${escapeHtml(lead.phone_number)}"
                        data-avatar="${escapeHtml(avatar)}">
                    <i class="bi bi-hand-index-thumb me-1"></i>Tomar chat
                </button>
            `;
        }
    } else if (a.status === "HUMAN_ACTIVE" && a.assigned_user) {
        sub = `<div class="small mt-1"><i class="bi bi-person-badge me-1"></i>Atendido por <strong>${escapeHtml(
            a.assigned_user.name
        )}</strong></div>`;

        if (a.assigned_user.is_me && a.conversation_id) {
            action = `
                <button type="button"
                        class="btn btn-outline-secondary btn-sm rounded-pill mt-2 btn-release-chat"
                        data-conversation-id="${a.conversation_id}">
                    <i class="bi bi-robot me-1"></i>Devolver al bot
                </button>
            `;
        }
    }

    const preview = a.last_message_preview
        ? `<div class="preview mt-1 text-truncate">"${escapeHtml(
              truncate(a.last_message_preview, 60)
          )}"</div>`
        : "";

    return `
        <span class="status-pill ${meta.cls}">
            <i class="bi ${meta.icon}"></i>${meta.label}
        </span>
        ${sub}
        ${preview}
        ${action}
    `;
};

const buildPageList = (current: number, last: number): Array<number | "…"> => {
    const pages = new Set<number>([1, last, current - 1, current, current + 1]);
    const sorted = [...pages]
        .filter((p) => p >= 1 && p <= last)
        .sort((a, b) => a - b);

    const out: Array<number | "…"> = [];
    sorted.forEach((p, idx) => {
        if (idx > 0 && p - sorted[idx - 1] > 1) {
            out.push("…");
        }
        out.push(p);
    });
    return out;
};

/* ---------- Componente Principal de Vista ---------- */

export class LeadsTableComponent {
    private root: HTMLElement;
    private tbody: HTMLTableSectionElement;
    private pageInfo: HTMLElement;
    private pagination: HTMLUListElement;
    private pageSizeSelect: HTMLSelectElement;
    private waitingSummary: HTMLElement;
    private contactsUrl: string;
    private service: LeadsTableService;

    private page: number = 1;
    private perPage: 5 | 10 = 10;
    private pollTimer: number | null = null;

    constructor(rootSelector: string = "#leads-table-root") {
        const rootEl = document.querySelector<HTMLElement>(rootSelector);
        if (!rootEl) {
            throw new Error(`No se encontró el contenedor ${rootSelector}`);
        }

        this.root = rootEl;
        this.tbody = rootEl.querySelector<HTMLTableSectionElement>("#leads-tbody")!;
        this.pageInfo = rootEl.querySelector<HTMLElement>("#page-info")!;
        this.pagination = rootEl.querySelector<HTMLUListElement>("#pagination")!;
        this.pageSizeSelect = rootEl.querySelector<HTMLSelectElement>("#page-size")!;
        this.waitingSummary = rootEl.querySelector<HTMLElement>("#waiting-summary")!;
        this.contactsUrl = rootEl.dataset.contactsUrl || "/admindashboard/contacts";

        this.service = new LeadsTableService();

        this.restoreInitialState();
        this.bindEvents();
        this.bindLiveChatModal();
        this.load(true);

        // Polling cada 15 segundos para actualizar estados y no leídos sin recargar la página
        this.pollTimer = window.setInterval(() => {
            this.load(false);
        }, 15000);
    }

    private restoreInitialState(): void {
        const params = new URLSearchParams(window.location.search);
        const urlPage = Number(params.get("page"));
        const urlPerPage = Number(params.get("per_page"));
        const storedPerPage = Number(localStorage.getItem("leads.perPage"));

        if (urlPerPage === 5 || urlPerPage === 10) {
            this.perPage = urlPerPage;
        } else if (storedPerPage === 5 || storedPerPage === 10) {
            this.perPage = storedPerPage;
        }

        if (urlPage >= 1) {
            this.page = urlPage;
        }

        if (this.pageSizeSelect) {
            this.pageSizeSelect.value = String(this.perPage);
        }
    }

    private syncUrl(): void {
        const url = new URL(window.location.href);
        url.searchParams.set("page", String(this.page));
        url.searchParams.set("per_page", String(this.perPage));
        window.history.replaceState({}, "", url.toString());
    }

    private renderSkeleton(): void {
        const rows = Array.from({ length: Math.min(this.perPage, 5) })
            .map(
                () => `
                <tr>
                    <td class="ps-4"><div class="placeholder-glow"><span class="placeholder col-8 rounded"></span></div></td>
                    <td><div class="placeholder-glow"><span class="placeholder col-7 rounded"></span></div></td>
                    <td class="pe-4"><div class="placeholder-glow"><span class="placeholder col-6 rounded"></span></div></td>
                </tr>`
            )
            .join("");
        this.tbody.innerHTML = rows;
    }

    public async load(showSkeleton: boolean = false): Promise<void> {
        if (showSkeleton) {
            this.renderSkeleton();
        }

        try {
            const response = await this.service.fetchLeads(this.page, this.perPage);
            this.renderRows(response.data);
            this.renderPagination(response.meta);
            this.renderWaitingSummary(response.meta.waiting_human_count);
            this.syncUrl();
        } catch (error) {
            console.error("[LeadsTable] Error al cargar leads:", error);
            if (showSkeleton) {
                this.tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center py-4 text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            No se pudieron cargar los leads.
                            <button type="button" class="btn btn-sm btn-outline-light ms-2" id="btn-retry-leads">Reintentar</button>
                        </td>
                    </tr>
                `;
            }
        }
    }

    private renderRows(leads: LeadRow[]): void {
        if (!leads.length) {
            this.tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center py-5">
                        <i class="bi bi-whatsapp fs-2 d-block mb-2 wsp-icon"></i>
                        <div class="fw-semibold">Aún no tienes leads registrados</div>
                        <div class="muted-xs">Cuando alguien escriba a tu número de WhatsApp aparecerá aquí.</div>
                    </td>
                </tr>
            `;
            return;
        }

        this.tbody.innerHTML = leads
            .map(
                (lead) => `
                <tr class="${lead.attention.status === "WAITING_HUMAN" ? "row-waiting" : ""}" data-row-lead-id="${lead.id}">
                    <td class="ps-4" data-label="Lead">${renderLeadCell(lead)}</td>
                    <td data-label="Contacto en plataforma">${renderContactCell(lead, this.contactsUrl)}</td>
                    <td class="pe-4" data-label="Estado de atención">${renderStatusCell(lead)}</td>
                </tr>
            `
            )
            .join("");
    }

    private renderPagination(meta: PaginationMeta): void {
        if (meta.total === 0) {
            this.pageInfo.textContent = "Mostrando 0 de 0 leads";
            this.pagination.innerHTML = "";
            return;
        }

        const from = meta.from ?? 0;
        const to = meta.to ?? 0;
        this.pageInfo.textContent = `Mostrando ${from}–${to} de ${meta.total} leads`;

        const current = meta.current_page;
        const last = Math.max(1, meta.last_page);

        const buildItem = (
            label: string,
            targetPage?: number,
            opts: { disabled?: boolean; active?: boolean; aria?: string } = {}
        ): string => {
            const disabledCls = opts.disabled ? "disabled" : "";
            const activeCls = opts.active ? "active" : "";

            if (label === "…") {
                return `<li class="page-item disabled"><span class="page-link">…</span></li>`;
            }

            return `
                <li class="page-item ${disabledCls} ${activeCls}">
                    <button type="button"
                            class="page-link"
                            data-page="${targetPage}"
                            ${opts.aria ? `aria-label="${opts.aria}"` : ""}
                            ${opts.active ? 'aria-current="page"' : ""}>
                        ${label}
                    </button>
                </li>
            `;
        };

        const pagesHtml = buildPageList(current, last)
            .map((p) =>
                p === "…"
                    ? buildItem("…")
                    : buildItem(String(p), p, { active: p === current })
            )
            .join("");

        this.pagination.innerHTML =
            buildItem('<i class="bi bi-chevron-left"></i> Anterior', current - 1, {
                disabled: current <= 1,
                aria: "Anterior",
            }) +
            pagesHtml +
            buildItem('Siguiente <i class="bi bi-chevron-right"></i>', current + 1, {
                disabled: current >= last,
                aria: "Siguiente",
            });
    }

    private renderWaitingSummary(waitingCount: number): void {
        if (!this.waitingSummary) return;
        this.waitingSummary.classList.toggle("d-none", waitingCount <= 0);
        const textSpan = this.waitingSummary.querySelector("span");
        if (textSpan) {
            textSpan.textContent = `${waitingCount} esperando humano`;
        }
    }

    private bindEvents(): void {
        // Cambio de cantidad de registros (5 o 10)
        this.pageSizeSelect.addEventListener("change", () => {
            const val = Number(this.pageSizeSelect.value);
            this.perPage = val === 5 ? 5 : 10;
            this.page = 1;
            localStorage.setItem("leads.perPage", String(this.perPage));
            this.load(true);
        });

        // Click en botones de paginación
        this.pagination.addEventListener("click", (event) => {
            const btn = (event.target as HTMLElement).closest<HTMLButtonElement>(
                "button[data-page]"
            );
            if (!btn || btn.closest(".disabled")) return;

            const targetPage = Number(btn.dataset.page);
            if (targetPage >= 1 && targetPage !== this.page) {
                this.page = targetPage;
                this.load(true);
            }
        });

        // Delegación de eventos en el cuerpo de la tabla
        this.tbody.addEventListener("click", async (event) => {
            const target = event.target as HTMLElement;

            // Reintentar carga
            if (target.closest("#btn-retry-leads")) {
                this.load(true);
                return;
            }

            // 1. Convertir Lead a Contacto
            const convertBtn = target.closest<HTMLButtonElement>(
                ".btn-convert-contact"
            );
            if (convertBtn) {
                const leadId = Number(convertBtn.dataset.leadId);
                if (!leadId) return;
                convertBtn.disabled = true;
                try {
                    await this.service.convertToContact(leadId);
                    await this.load(false);
                } finally {
                    convertBtn.disabled = false;
                }
                return;
            }

            // 2. Tomar chat directamente desde la columna de Estado
            const takeBtn = target.closest<HTMLButtonElement>(".btn-take-chat");
            if (takeBtn) {
                const convId = Number(takeBtn.dataset.conversationId);
                const leadId = Number(takeBtn.dataset.leadId);
                if (!convId || !leadId) return;

                takeBtn.disabled = true;
                try {
                    await this.service.takeControl(convId, "human_active");
                    await this.load(false);

                    // Abrir el modal de Live Chat para atender al lead
                    this.openLiveChatModal({
                        leadId,
                        name: takeBtn.dataset.name || "",
                        phone: takeBtn.dataset.phone || "",
                        avatar: takeBtn.dataset.avatar || "",
                    });
                } finally {
                    takeBtn.disabled = false;
                }
                return;
            }

            // 3. Devolver el chat al bot desde la columna de Estado
            const releaseBtn = target.closest<HTMLButtonElement>(
                ".btn-release-chat"
            );
            if (releaseBtn) {
                const convId = Number(releaseBtn.dataset.conversationId);
                if (!convId) return;

                releaseBtn.disabled = true;
                try {
                    await this.service.takeControl(convId, "bot_active");
                    await this.load(false);
                } finally {
                    releaseBtn.disabled = false;
                }
            }
        });
    }

    private openLiveChatModal(detail: {
        leadId: number;
        name: string;
        phone: string;
        avatar: string;
    }): void {
        const modalEl = document.getElementById("staticBackdrop");
        const wrapper = document.getElementById("wspservice-chat-wrapper");

        if (wrapper) {
            wrapper.setAttribute("data-lead-id", String(detail.leadId));
            document.dispatchEvent(new CustomEvent("InitLiveChat", { detail }));
        }

        if (modalEl) {
            const bsModal =
                (window as any).bootstrap?.Modal?.getOrCreateInstance?.(modalEl);
            if (bsModal) {
                bsModal.show();
            } else {
                // Fallback: disparar clic en el botón Chat Live de la fila
                const rowBtn = this.tbody.querySelector<HTMLButtonElement>(
                    `.btn-open-chat[data-value="${detail.leadId}"]`
                );
                rowBtn?.click();
            }
        }
    }

    private bindLiveChatModal(): void {
        const modal = document.getElementById("staticBackdrop");
        if (!modal) return;

        modal.addEventListener("show.bs.modal", (event: any) => {
            const button = event.relatedTarget as HTMLElement | null;
            if (!button) return;

            const leadId = Number(button.getAttribute("data-value"));
            if (!leadId) return;

            const leadName = button.getAttribute("data-name") || "";
            const leadPhone = button.getAttribute("data-phone") || "";
            const leadAvatar = button.getAttribute("data-avatar") || "";

            const wrapper = document.getElementById("wspservice-chat-wrapper");
            if (wrapper) {
                wrapper.setAttribute("data-lead-id", String(leadId));
                document.dispatchEvent(
                    new CustomEvent("InitLiveChat", {
                        detail: {
                            leadId,
                            name: leadName,
                            phone: leadPhone,
                            avatar: leadAvatar,
                        },
                    })
                );
            }
        });

        modal.addEventListener("hidden.bs.modal", () => {
            document.dispatchEvent(new CustomEvent("DestroyLiveChat"));

            const container = document.getElementById("chat-messages-container");
            if (container) {
                container.innerHTML =
                    '<div class="text-center text-muted my-auto"><div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div><small>Cargando mensajes...</small></div>';
            }

            // Al cerrar el modal refrescamos la tabla para reflejar cambios de estado o mensajes leídos
            this.load(false);
        });
    }

    public destroy(): void {
        if (this.pollTimer) {
            clearInterval(this.pollTimer);
        }
    }
}

export const initLeadsTable = (): LeadsTableComponent | null => {
    if (!document.getElementById("leads-table-root")) {
        return null;
    }
    return new LeadsTableComponent("#leads-table-root");
};
