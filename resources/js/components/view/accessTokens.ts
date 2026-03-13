import ApiService from "../../core/ApiService";

export interface PersonalAccessTokenRecord {
  id: number;
  tokenable_type: string;
  tokenable_id: number;
  name: string;
  token: string;
  abilities: string[];
  last_used_at: string | null;
  created_at: string;
  updated_at: string;
}

interface TokenCreationPayload {
  token: PersonalAccessTokenRecord;
  plain_text_token: string;
}

class AccessTokenService extends ApiService {
  constructor() {
    super("/profile/api-tokens");
  }

  async listTokens(): Promise<PersonalAccessTokenRecord[]> {
    const response = await this.get<{ tokens: PersonalAccessTokenRecord[] }>("");
    return response.data?.data?.tokens ?? [];
  }

  async createToken(name: string): Promise<TokenCreationPayload> {
    const response = await this.post<TokenCreationPayload>("/create", { name });
    const payload = response.data?.data;
    if (!payload) {
      throw new Error("Respuesta inesperada al crear el token");
    }
    return payload;
  }

  async revokeToken(id: number): Promise<void> {
    await this.delete(`/${id}`);
  }
}

const formatDate = (value?: string | null) => {
  if (!value) {
    return "Nunca";
  }
  try {
    return new Date(value).toLocaleString("es-CL");
  } catch {
    return value;
  }
};




/**
 * 
 * @param token este parametro es del tipo interface que creamos al principio PersonalAccessTokenRecord
 *             esla estructura de datos del Token que susa la API 
 * @returns 
 */
const buildRow = (token: PersonalAccessTokenRecord) => {
  return `
    <tr data-token-id="${token.id}">
      <td>${token.name}</td>
      <td>${formatDate(token.created_at)}</td>
      <td>${token.last_used_at ? formatDate(token.last_used_at) : "Nunca"}</td>
      <td>
        <button type="button" class="btn btn-sm btn-outline-danger revoke-token" data-revoke-id="${token.id}">
          Revocar
        </button>
      </td>
    </tr>
  `;
};

const renderTokens = (tokens: PersonalAccessTokenRecord[], container: HTMLTableSectionElement) => {
  if (!tokens.length) {
    container.innerHTML = `
      <tr>
        <td colspan="4" class="text-muted text-center py-3">
          Aún no tienes tokens de acceso creados.
        </td>
      </tr>
    `;
    return;
  }

  container.innerHTML = tokens.map(buildRow).join("");
};

const showMessage = (container: HTMLDivElement | null, text: string, variant: "success" | "danger" | "info" = "info") => {
  if (!container) {
    return;
  }

  container.className = `alert alert-${variant}`;
  container.textContent = text;
  container.hidden = false;
};

const clearMessage = (container: HTMLDivElement | null) => {
  if (!container) {
    return;
  }

  container.hidden = true;
};

const displayPlainToken = (container: HTMLDivElement | null, token: string) => {
  if (!container) {
    return;
  }

  container.innerHTML = `<strong>Token generado:</strong> <span class="text-break">${token}</span>`;
  container.classList.remove("d-none");
};

const clearPlainTextDisplay = (container: HTMLDivElement | null) => {
  if (!container) {
    return;
  }

  container.classList.add("d-none");
  container.textContent = "";
};

const accessTokenApp = () => {
  const tableBody = document.querySelector<HTMLTableSectionElement>("#tokens-table-body");
  const form = document.querySelector<HTMLFormElement>("#create-token-form");
  const messageContainer = document.querySelector<HTMLDivElement>("#tokens-message");
  const plainTextContainer = document.querySelector<HTMLDivElement>("#plain-text-token");

  if (!tableBody || !form) {
    return;
  }

  const service = new AccessTokenService();

  const refreshTokens = async () => {
    try {
      const tokens = await service.listTokens();
      renderTokens(tokens, tableBody);
      clearPlainTextDisplay(plainTextContainer);
    } catch (error) {
      showMessage(messageContainer, "No fue posible cargar los tokens. Intenta nuevamente.", "danger");
    }
  };

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    clearMessage(messageContainer);
    clearPlainTextDisplay(plainTextContainer);

    const formData = new FormData(form);
    const name = (formData.get("name") as string | null)?.trim();

    if (!name) {
      showMessage(messageContainer, "Agrega un nombre válido antes de crear el token.", "danger");
      return;
    }

    try {
      const response = await service.createToken(name);
      showMessage(messageContainer, "Token creado correctamente.", "success");
      displayPlainToken(plainTextContainer, response.plain_text_token);
      form.reset();
      await refreshTokens();
    } catch (error) {
      showMessage(
        messageContainer,
        "No fue posible crear el token. Verifica el nombre e inténtalo de nuevo.",
        "danger"
      );
    }
  });

  tableBody.addEventListener("click", async (event) => {
    const button = (event.target as HTMLElement).closest<HTMLButtonElement>(".revoke-token");

    if (!button) {
      return;
    }

    event.preventDefault();

    const tokenId = Number(button.dataset.revokeId);
    if (!tokenId) {
      return;
    }

    try {
      await service.revokeToken(tokenId);
      showMessage(messageContainer, "Token revocado correctamente.", "success");
      await refreshTokens();
    } catch (error) {
      showMessage(messageContainer, "No fue posible revocar el token. Intenta nuevamente.", "danger");
    }
  });

  refreshTokens();
};

document.addEventListener("DOMContentLoaded", () => {
  if (document.querySelector("#access-token-manager")) {
    accessTokenApp();
  }
});
