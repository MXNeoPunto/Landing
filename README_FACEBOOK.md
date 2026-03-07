# Guía de Configuración para el Inicio de Sesión con Facebook

Este documento detalla los pasos necesarios para configurar y activar el inicio de sesión con Facebook en la plataforma NeoPunto, cumpliendo con todos los requisitos de las políticas de desarrolladores de Facebook.

## 1. Crear la aplicación en Facebook Developers

1. Ve a [Facebook for Developers](https://developers.facebook.com/) y accede con tu cuenta.
2. Haz clic en "Mis aplicaciones" y luego en "Crear aplicación".
3. Selecciona el tipo de aplicación adecuado (por ejemplo, "Consumidor" o "Ninguno", dependiendo de tus necesidades) y completa la información básica de la aplicación.
4. Una vez creada, en el panel lateral, ve a **Agregar producto** y selecciona **Inicio de sesión con Facebook (Facebook Login)**.

## 2. Configuración de la App

Ve a **Configuración > Información básica** en el panel de tu aplicación de Facebook y completa los siguientes campos:

*   **URL de la Política de Privacidad:** Debes ingresar la URL exacta hacia la página de política de privacidad que hemos actualizado en la raíz de tu dominio:
    `https://tudominio.com/politica-de-privacidad.php`
*   **URL de las Condiciones del Servicio:** Ingresa la URL de tus términos y condiciones (por ejemplo, `https://tudominio.com/terminos.php`).
*   **URL de Eliminación de Datos del Usuario:** Este es un requisito obligatorio. Hemos creado una página específica para ello. Ingresa la siguiente URL:
    `https://tudominio.com/eliminacion_datos.php`
*   **Categoría:** Selecciona la categoría que mejor describa a tu agencia (ej. Negocios y páginas).
*   **Icono de la aplicación:** Sube un logotipo de NeoPunto que cumpla con los tamaños requeridos.

Guarda los cambios al final de la página.

## 3. Configuración del Inicio de Sesión con Facebook

Ve a **Inicio de sesión con Facebook > Configuración** en el panel lateral y ajusta lo siguiente:

*   **Inicio de sesión del cliente OAuth:** Actívalo (Sí).
*   **Inicio de sesión con SDK para la web:** Actívalo (Sí) si usarás el SDK en JavaScript (opcional, actualmente está implementado mediante redirección estándar).
*   **URI de redireccionamiento de OAuth válidos:** Aquí debes ingresar la URL de tu controlador que manejará la respuesta de Facebook. Por ejemplo:
    `https://tudominio.com/controllers/AuthController.php?action=oauth_facebook`
    *(Asegúrate de que esta URL coincida exactamente con la que está configurada en el botón de inicio de sesión en `auth/login.php`)*.

Guarda los cambios.

## 4. Obtener Credenciales y Actualizar el Código

1.  En la página **Configuración > Información básica**, encontrarás el **Identificador de la aplicación (App ID)** y la **Clave secreta de la aplicación (App Secret)**.
2.  En el archivo de tu proyecto `auth/login.php`, busca el enlace del botón de Facebook y reemplaza `YOUR_FACEBOOK_APP_ID` por tu Identificador de la aplicación real. También asegúrate de reemplazar `https://neopunto.com` con tu dominio real si difiere.
3.  En `controllers/AuthController.php`, deberás implementar la lógica real para validar el `code` devuelto por Facebook y cambiarlo por un `access_token` utilizando tu App ID y App Secret, y posteriormente obtener los datos del usuario. Actualmente, este archivo contiene un *stub* (simulador) de cómo debería verse.

## 5. Poner la aplicación en Modo Activo (Producción)

En la barra superior del panel de Facebook Developers, cambia el estado de la aplicación de **En desarrollo** a **Activa**. Para hacer esto, es indispensable haber completado la configuración de las URLs de Privacidad y Eliminación de Datos, que ya han sido desarrolladas y subidas a la plataforma.

## Notas Adicionales sobre Políticas y Cumplimiento

*   **Política de Privacidad (`politica-de-privacidad.php`):** Se ha agregado una sección que explica claramente el uso de la API de Facebook para iniciar sesión y qué datos se solicitan (nombre, email y foto de perfil público).
*   **Página de Eliminación de Datos (`eliminacion_datos.php`):** Esta página ofrece instrucciones a los usuarios sobre cómo pueden solicitar la eliminación de su información mediante correo electrónico o removiendo los permisos directamente desde la interfaz de Facebook, cumpliendo así con las directrices de privacidad y control de datos requeridas por Facebook.
*   **Condición Previa:** Se ha agregado el texto indicativo en la pantalla de inicio de sesión especificando que "Solo se puede iniciar o conectar redes sociales si ya creó una cuenta", como se solicitó.