#!/usr/bin/env python3
"""
Script para generar assets placeholder para la app RamboPet
"""
from PIL import Image, ImageDraw, ImageFont
import os

# Directorio de assets
assets_dir = os.path.join(os.path.dirname(__file__), 'assets')
os.makedirs(assets_dir, exist_ok=True)

def create_icon(size, filename, text="RP"):
    """Crea un icono con fondo degradado y texto"""
    # Crear imagen con fondo
    img = Image.new('RGB', (size, size), color='#FF6B35')
    draw = ImageDraw.Draw(img)

    # Dibujar círculo interno naranja más claro
    margin = size // 6
    draw.ellipse([margin, margin, size-margin, size-margin], fill='#FF8C42', outline='#FFFFFF', width=size//20)

    # Agregar texto
    try:
        # Intentar usar una fuente del sistema
        font_size = size // 3
        font = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf", font_size)
    except:
        # Si no hay fuente disponible, usar la predeterminada
        font = ImageFont.load_default()

    # Calcular posición del texto para centrarlo
    bbox = draw.textbbox((0, 0), text, font=font)
    text_width = bbox[2] - bbox[0]
    text_height = bbox[3] - bbox[1]
    position = ((size - text_width) // 2, (size - text_height) // 2 - size//20)

    # Dibujar texto con sombra
    shadow_offset = size // 100
    draw.text((position[0] + shadow_offset, position[1] + shadow_offset), text, font=font, fill='#00000040')
    draw.text(position, text, font=font, fill='#FFFFFF')

    # Guardar
    filepath = os.path.join(assets_dir, filename)
    img.save(filepath, 'PNG')
    print(f"✓ Creado: {filename} ({size}x{size}px)")

def create_splash(filename):
    """Crea un splash screen"""
    width, height = 1284, 2778
    img = Image.new('RGB', (width, height), color='#FF6B35')
    draw = ImageDraw.Draw(img)

    # Dibujar círculo central
    center_x, center_y = width // 2, height // 2
    radius = min(width, height) // 4
    draw.ellipse([center_x - radius, center_y - radius, center_x + radius, center_y + radius],
                 fill='#FF8C42', outline='#FFFFFF', width=10)

    # Agregar texto
    try:
        font = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf", 120)
        small_font = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf", 60)
    except:
        font = ImageFont.load_default()
        small_font = ImageFont.load_default()

    # Texto principal
    text = "RamboPet"
    bbox = draw.textbbox((0, 0), text, font=font)
    text_width = bbox[2] - bbox[0]
    position = ((width - text_width) // 2, center_y - 80)
    draw.text(position, text, font=font, fill='#FFFFFF')

    # Subtítulo
    subtitle = "Clínica Veterinaria"
    bbox2 = draw.textbbox((0, 0), subtitle, font=small_font)
    text_width2 = bbox2[2] - bbox2[0]
    position2 = ((width - text_width2) // 2, center_y + 80)
    draw.text(position2, subtitle, font=small_font, fill='#FFFFFF')

    # Guardar
    filepath = os.path.join(assets_dir, filename)
    img.save(filepath, 'PNG')
    print(f"✓ Creado: {filename} ({width}x{height}px)")

def create_adaptive_icon(size, filename):
    """Crea icono adaptativo para Android"""
    img = Image.new('RGBA', (size, size), color=(0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Dibujar círculo con fondo
    draw.ellipse([0, 0, size, size], fill='#FF6B35')

    # Círculo interno
    margin = size // 4
    draw.ellipse([margin, margin, size-margin, size-margin], fill='#FF8C42', outline='#FFFFFF', width=size//30)

    # Texto
    try:
        font_size = size // 3
        font = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf", font_size)
    except:
        font = ImageFont.load_default()

    text = "RP"
    bbox = draw.textbbox((0, 0), text, font=font)
    text_width = bbox[2] - bbox[0]
    text_height = bbox[3] - bbox[1]
    position = ((size - text_width) // 2, (size - text_height) // 2 - size//20)
    draw.text(position, text, font=font, fill='#FFFFFF')

    # Guardar
    filepath = os.path.join(assets_dir, filename)
    img.save(filepath, 'PNG')
    print(f"✓ Creado: {filename} ({size}x{size}px)")

if __name__ == '__main__':
    print("Generando assets para RamboPet...\n")

    # Icon principal (1024x1024)
    create_icon(1024, 'icon.png', 'RP')

    # Favicon (48x48)
    create_icon(48, 'favicon.png', 'RP')

    # Splash screen
    create_splash('splash.png')

    # Adaptive icon (512x512 para Android)
    create_adaptive_icon(512, 'adaptive-icon.png')

    print("\n✅ Todos los assets han sido generados exitosamente!")
    print(f"📁 Ubicación: {assets_dir}")
