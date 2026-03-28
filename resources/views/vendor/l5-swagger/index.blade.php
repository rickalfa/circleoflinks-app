<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{config('l5-swagger.documentations.'.$documentation.'.api.title')}}</title>
    <link rel="stylesheet" type="text/css" href="{{ l5_swagger_asset($documentation, 'swagger-ui.css') }}">
    <link rel="icon" type="image/png" href="{{ l5_swagger_asset($documentation, 'favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ l5_swagger_asset($documentation, 'favicon-16x16.png') }}" sizes="16x16"/>
    <style>
    html
    {
        box-sizing: border-box;
        overflow: -moz-scrollbars-vertical;
        overflow-y: scroll;
    }
    *,
    *:before,
    *:after
    {
        box-sizing: inherit;
    }

    body {
      margin:0;
      background: #f8fafc;
      color: #0f172a;
      font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
    }

    .swagger-layout {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .swagger-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 24px;
      background: #0f172a;
      color: #ffffff;
      border-bottom: 1px solid #1f2937;
    }

    .swagger-header .brand {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .swagger-header .title {
      font-size: 18px;
      font-weight: 700;
      letter-spacing: 0.2px;
    }

    .swagger-header .subtitle {
      font-size: 12px;
      opacity: 0.8;
    }

    .swagger-header .header-meta {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      justify-content: flex-end;
    }

    .swagger-header .pill {
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 999px;
      padding: 4px 10px;
      font-size: 12px;
      opacity: 0.9;
    }

    #swagger-ui {
      flex: 1;
      padding-bottom: 32px;
    }

    .swagger-footer {
      padding: 10px 24px;
      background: #f1f5f9;
      color: #475569;
      font-size: 12px;
      border-top: 1px solid #e2e8f0;
    }
    </style>
</head>

<body>
<div class="swagger-layout">
    <header class="swagger-header">
        <div class="brand">
            <div class="title">{{ config('app.name', 'API') }}</div>
            <div class="subtitle">{{ config('l5-swagger.documentations.'.$documentation.'.api.title') }}</div>
        </div>
        <div class="header-meta">
            <span class="pill">ENV: {{ config('app.env') }}</span>
            <span class="pill">Docs UI</span>
        </div>
    </header>

    <div id="swagger-ui"></div>

    <footer class="swagger-footer">
        Documentacion generada con Swagger UI - {{ date('Y') }} - {{ config('app.name', 'API') }}
    </footer>
</div>

<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-bundle.js') }}"></script>
<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js') }}"></script>
<script>
    window.onload = function() {
        // Build a system
        const ui = SwaggerUIBundle({
            dom_id: '#swagger-ui',
            url: "{!! $urlToDocs !!}",
            operationsSorter: {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
            configUrl: {!! isset($configUrl) ? '"' . $configUrl . '"' : 'null' !!},
            validatorUrl: {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
            oauth2RedirectUrl: "{{ route('l5-swagger.'.$documentation.'.oauth2_callback', [], $useAbsolutePath) }}",

            requestInterceptor: function(request) {
                request.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
                return request;
            },

            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],

            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],

            layout: "StandaloneLayout",
            docExpansion : "{!! config('l5-swagger.defaults.ui.display.doc_expansion', 'none') !!}",
            deepLinking: true,
            filter: {!! config('l5-swagger.defaults.ui.display.filter') ? 'true' : 'false' !!},
            persistAuthorization: "{!! config('l5-swagger.defaults.ui.authorization.persist_authorization') ? 'true' : 'false' !!}",

        })

        window.ui = ui

        @if(in_array('oauth2', array_column(config('l5-swagger.defaults.securityDefinitions.securitySchemes'), 'type')))
        ui.initOAuth({
            usePkceWithAuthorizationCodeGrant: "{!! (bool)config('l5-swagger.defaults.ui.authorization.oauth2.use_pkce_with_authorization_code_grant') !!}"
        })
        @endif
    }
</script>
</body>
</html>

