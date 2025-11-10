#!/bin/bash

# Script para iniciar DOBLE túnel ngrok: Backend Laravel + Frontend React Native

echo "========================================"
echo "   RamboPet - Doble Túnel ngrok"
echo "========================================"
echo ""

# Verificar que ngrok esté instalado
if ! command -v ngrok &> /dev/null; then
    echo "× Error: ngrok no está instalado"
    echo ""
    echo "Descarga ngrok desde: https://ngrok.com/download"
    exit 1
fi

echo "[1/2] Configurando authtoken de ngrok..."
ngrok config add-authtoken 35GVso3SIgSSI84JGlWOePw39fL_7vjXVGFs4G7hE2biAMnFG

if [ $? -eq 0 ]; then
    echo "✓ Authtoken configurado"
else
    echo "× Error al configurar authtoken"
    exit 1
fi

echo ""
echo "[2/2] Iniciando DOBLE túnel ngrok..."
echo ""
echo "========================================"
echo "   Túneles Activos:"
echo "========================================"
echo "   1. Backend Laravel  : Puerto 8000"
echo "   2. Frontend React   : Puerto 8081"
echo "========================================"
echo ""
echo "IMPORTANTE:"
echo "- El backend Laravel debe estar corriendo: php artisan serve"
echo "- La app React Native debe estar corriendo: npm run web (en carpeta mobile)"
echo ""
echo "Presiona Ctrl+C para detener los túneles"
echo ""
echo "Las URLs aparecerán a continuación..."
echo ""

# Iniciar ambos túneles usando el archivo de configuración
ngrok start --all --config ngrok.yml
