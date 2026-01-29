// utils/jsonFormatter.ts

export function syntaxHighlight(json: any): string {
    if (typeof json !== 'string') {
        json = JSON.stringify(json, undefined, 2); // Ordenar con 2 espacios
    }

    // Escapar caracteres HTML básicos
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

    // Expresión regular mágica para detectar partes del JSON
    const regex = /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g;

    return json.replace(regex, (match: string) => {
        let cls = 'json-number';
        
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'json-key';
            } else {
                cls = 'json-string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'json-boolean';
        } else if (/null/.test(match)) {
            cls = 'json-null';
        }
        
        return `<span class="${cls}">${match}</span>`;
    });
}