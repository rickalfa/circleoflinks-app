---
name: project-standards
description: Enforces npm build and Spanish commit messages.
trigger: always_on
---

# Reglas del Proyecto (Project Standards)

1. **Idioma de los Commits**: Todos los mensajes de commit en Git deben escribirse estrictamente en **Español** y deben seguir un formato descriptivo (ej. `Feat: ...`, `Fix: ...`).
2. **Compilación de Assets**: Siempre que modifiques archivos del Front-end (como TypeScript, Vue, Blade o CSS/SCSS), **debes ejecutar** `npm run build` usando la consola para asegurar que los cambios se compilen con Vite antes de hacer commit o de avisar al usuario.
