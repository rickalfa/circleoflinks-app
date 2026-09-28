---
name: project-standards
description: Enforces npm build, Spanish commit messages, and modular SCSS styles.
trigger: always_on
---

# Reglas del Proyecto (Project Standards)

1. **Idioma de los Commits**: Todos los mensajes de commit en Git deben escribirse estrictamente en **Español** y deben seguir un formato descriptivo (ej. `Feat: ...`, `Fix: ...`).
2. **Compilación de Assets**: Siempre que modifiques archivos del Front-end (como TypeScript, Vue, Blade o CSS/SCSS), **debes ejecutar** `npm run build` usando la consola para asegurar que los cambios se compilen con Vite antes de hacer commit o de avisar al usuario.
3. **Modularización de Estilos SCSS**: Todos los estilos específicos de un componente de UI o vista (como Leads, Live Chat, Modales, etc.) deben crearse en su propio archivo modular `.scss` dentro de `resources/css/stylesapp/components/` (ej. `_chat_leads.scss`, `_leads_table.scss`) e importarse debidamente en `resources/css/stylesapp/app.scss`.

