// types/schema.ts
export interface Field {
  name: string;
  type: string;
  isPK?: boolean;
  isFK?: boolean;
  description: string;
}

export interface Table {
  name: string;
  description: string;
  fields: Field[];
}

// Datos basados en tu proyecto Circle Of Links
export const circleOfLinksSchema: Table[] = [
  {
    name: "users",
    description: "Almacena los datos básicos de autenticación y acceso.",
    fields: [
      { name: "id", type: "BIGINT", isPK: true, description: "Identificador único" },
      { name: "name", type: "VARCHAR(255)", description: "Nombre completo del usuario" },
      { name: "email", type: "VARCHAR(255)", description: "Correo único registrado" },
      { name: "password", type: "VARCHAR(255)", description: "Hash de seguridad" }
    ]
  },
  {
    name: "profiles",
    description: "Contiene la información profesional y biografía.",
    fields: [
      { name: "id", type: "BIGINT", isPK: true, description: "ID del perfil" },
      { name: "user_id", type: "BIGINT", isFK: true, description: "Relación con tabla users" },
      { name: "bio", type: "TEXT", description: "Resumen profesional" },
      { name: "avatar", type: "VARCHAR(255)", description: "Ruta de la imagen" }
    ]
  }

  


];