import { syntaxHighlight } from "../../utils/jsonFormatter.ts";


export function jsonView(): void{
        const apiResponse = {
        
            success: true,
            status: 200,
            message: "Empresa encontrada",
            data: {
                id: 2,
                name: "Ms. Yolanda Nolan II EnterPrise",
                email: "ford35@example.net",
                avatar: null,
                address: "Street 6944 Vivian Curve\nLake Juwan, TN 75283",
                rubro: "mineria",
                created_at: "2026-02-02T01:33:42.000000Z",
                updated_at: "2026-02-02T01:33:42.000000Z"
            },
            "errors": null,
            "meta": []
            
        };

        const viewer = document.getElementById('box-json');
        if (viewer) {
            viewer.innerHTML = syntaxHighlight(apiResponse);
        }
}