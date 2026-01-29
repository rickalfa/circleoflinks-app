// components/SchemaRenderer.ts
import { circleOfLinksSchema, Table } from "../types/Schema";

export class SchemaRenderer {
  render(containerId: string): void {
    const container = document.getElementById(containerId);
    if (!container) return;

    let html = '<div class="row g-4">';

    circleOfLinksSchema.forEach((table: Table) => {
      html += `
        <div class="col-md-6 col-lg-4">
          <div class="card table-card h-100">
            <div class="card-header d-flex justify-content-between">
              <span>${table.name}</span>
              <i class="bi bi-table"></i>
            </div>
            <div class="card-body p-0">
              <p class="p-3 text-muted mb-0 small">${table.description}</p>
              <ul class="list-unstyled mb-0">
                ${table.fields.map(f => `
                  <li class="field-item d-flex justify-content-between align-items-center">
                    <div>
                      ${f.isPK ? '<span class="badge badge-pk me-1">PK</span>' : ''}
                      ${f.isFK ? '<span class="badge badge-fk me-1">FK</span>' : ''}
                      <strong>${f.name}</strong>
                    </div>
                    <span class="field-type">${f.type}</span>
                  </li>
                `).join('')}
              </ul>
            </div>
          </div>
        </div>`;
    });

    html += '</div>';
    container.innerHTML = html;
  }
}