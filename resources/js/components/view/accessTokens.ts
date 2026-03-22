import ApiService from "../../core/ApiService";

export interface PersonalAccessTokenRecord {
  id: number;
  tokenable_type: string;
  tokenable_id: number;
  name: string;
  token: string;
  has_plain_text_token: boolean;
  abilities: string[];
  last_used_at: string | null;
  created_at: string;
  updated_at: string;
  expires_at: string | null;
}

interface TokenCreationPayload {
  token: PersonalAccessTokenRecord;
  plain_text_token: string;
}

class AccessTokenService extends ApiService {
  constructor() {
    super("/profile/api-tokens");

    console.log("Creacion de objeto AccessTokenService");


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

  async getPlainToken(id: number): Promise<string> {
    const response = await this.get<{ plain_text_token: string }>(`/${id}/plain`);
    const token = response.data?.data?.plain_text_token;
    if (!token) {
      throw new Error("Token no disponible");
    }
    return token;
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
 *             es la estructura de datos del Token que usa la API 
 * @returns 
 */
const buildRow = (token: PersonalAccessTokenRecord) => {
  const viewButton = token.has_plain_text_token
    ? `<button type="button" class="btn btn-sm btn-outline-primary view-token" data-view-id="${token.id}">Ver token</button>`
    : `<span class="text-muted small">No disponible</span>`;

  const abilities = Array.isArray(token.abilities) ? token.abilities.join(", ") : "";

  return `
    <tr data-token-id="${token.id}">
      <td>${token.name}</td>
      <td>${formatDate(token.created_at)}</td>
      <td>${token.last_used_at ? formatDate(token.last_used_at) : "Nunca"}</td>
      <td>${abilities}</td>
      <td>
        ${viewButton}
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
        <td colspan="5" class="text-muted text-center py-3">
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

const showTokenRowPreview = (tableBody: HTMLTableSectionElement, anchorRow: HTMLTableRowElement, token: string) => {
  tableBody.querySelectorAll(".token-preview-row").forEach((row) => row.remove());

  const previewRow = document.createElement("tr");
  previewRow.className = "token-preview-row";
  previewRow.innerHTML = `
    <td colspan="5">
      <div class="bg-white border rounded shadow-sm p-2 text-center">
        <div class="fw-semibold mb-1">Token generado</div>
        <div class="text-break small">${token}</div>
      </div>
    </td>
  `;

  tableBody.insertBefore(previewRow, anchorRow);

  window.setTimeout(() => {
    previewRow.remove();
  }, 6000);
};


/**
 *  Funcion que inicializa las funciones logicas de crear y mostrar los toknes creados en la tabla
 * 
 * @returns 
 */
const accessTokenApp = () => {
  const tableBody = document.querySelector<HTMLTableSectionElement>("#tokens-table-body");
  const form = document.querySelector<HTMLFormElement>("#create-token-form");
  const messageContainer = document.querySelector<HTMLDivElement>("#tokens-message");

  if (!tableBody || !form) {
    return;
  }

  const service = new AccessTokenService();

  /**
   * carga los tokens , Si existen, en el tablebody con el metodo renderTokens() 
   */
  const refreshTokens = async () => {
    try {
      const tokens = await service.listTokens();
      renderTokens(tokens, tableBody);
    } catch (error) {
      showMessage(messageContainer, "No fue posible cargar los tokens. Intenta nuevamente.", "danger");
    }
  };

  /**
   * Formulario para crear Token el formulario esta en un modal con un solo input el nombre
   */
  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    clearMessage(messageContainer);

    const formData = new FormData(form);
    const name = (formData.get("name") as string | null)?.trim();

    if (!name) {
      showMessage(messageContainer, "Agrega un nombre válido antes de crear el token.", "danger");
      return;
    }

    try {
      const response = await service.createToken(name);
      showMessage(messageContainer, "Token creado correctamente.", "success");
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


 /**
  * metodo para mostrar el text_plain del Token por unos instantes
  */

  tableBody.addEventListener("click", async (event) => {
    const viewButton = (event.target as HTMLElement).closest<HTMLButtonElement>(".view-token");
    if (viewButton) {
      event.preventDefault();

      const tokenId = Number(viewButton.dataset.viewId);
      if (!tokenId) {
        return;
      }

      const row = viewButton.closest("tr");
      if (!row) {
        return;
      }

      try {
        const token = await service.getPlainToken(tokenId);
        showTokenRowPreview(tableBody, row, token);
      } catch (error) {
        showMessage(messageContainer, "No fue posible mostrar el token.", "danger");
      }
      return;
    }

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
