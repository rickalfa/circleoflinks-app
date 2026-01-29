import { syntaxHighlight } from "../../utils/jsonFormatter.ts";


export function jsonView(): void{
        const apiResponse = {
            success: true,
            status: 200,
            message: "Listado de empresas obtenido correctamente",
            data: [
                { id: 1, name: "Empresa X", email: "contacto@empresa.cl" }
            ],
            errors: null,
            meta: {
                current_page: 1,
                per_page: 10,
                total: 120,
                last_page: 12
            }
        };

        const viewer = document.getElementById('box-json');
        if (viewer) {
            viewer.innerHTML = syntaxHighlight(apiResponse);
        }
}