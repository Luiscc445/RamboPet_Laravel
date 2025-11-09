<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especie;
use App\Models\Raza;

class EspecieRazaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear especies
        $perro = Especie::create([
            'nombre' => 'Perro',
            'descripcion' => 'Canis familiaris',
        ]);

        $gato = Especie::create([
            'nombre' => 'Gato',
            'descripcion' => 'Felis catus',
        ]);

        $ave = Especie::create([
            'nombre' => 'Ave',
            'descripcion' => 'Aves de compañía',
        ]);

        $roedor = Especie::create([
            'nombre' => 'Roedor',
            'descripcion' => 'Roedores domésticos',
        ]);

        $reptil = Especie::create([
            'nombre' => 'Reptil',
            'descripcion' => 'Reptiles domésticos',
        ]);

        // Razas de perros
        $razasPerros = [
            ['nombre' => 'Labrador Retriever', 'descripcion' => 'Amigable, enérgico, ideal para familias'],
            ['nombre' => 'Pastor Alemán', 'descripcion' => 'Inteligente, leal, buen guardián'],
            ['nombre' => 'Golden Retriever', 'descripcion' => 'Amable, confiable, gentil'],
            ['nombre' => 'Bulldog Francés', 'descripcion' => 'Juguetón, adaptable, sociable'],
            ['nombre' => 'Beagle', 'descripcion' => 'Curioso, amigable, excelente olfato'],
            ['nombre' => 'Poodle', 'descripcion' => 'Inteligente, activo, hipoalergénico'],
            ['nombre' => 'Chihuahua', 'descripcion' => 'Pequeño, valiente, leal'],
            ['nombre' => 'Yorkshire Terrier', 'descripcion' => 'Pequeño, enérgico, cariñoso'],
            ['nombre' => 'Mestizo', 'descripcion' => 'Variado, único'],
        ];

        foreach ($razasPerros as $raza) {
            Raza::create([
                'especie_id' => $perro->id,
                'nombre' => $raza['nombre'],
                'descripcion' => $raza['descripcion'],
            ]);
        }

        // Razas de gatos
        $razasGatos = [
            ['nombre' => 'Persa', 'descripcion' => 'Tranquilo, pelaje largo, cara achatada'],
            ['nombre' => 'Siamés', 'descripcion' => 'Vocal, sociable, elegante'],
            ['nombre' => 'Maine Coon', 'descripcion' => 'Grande, pelaje largo, amigable'],
            ['nombre' => 'Bengalí', 'descripcion' => 'Activo, patrón de leopardo, juguetón'],
            ['nombre' => 'Británico de Pelo Corto', 'descripcion' => 'Robusto, independiente, tranquilo'],
            ['nombre' => 'Ragdoll', 'descripcion' => 'Dócil, relajado, ojos azules'],
            ['nombre' => 'Mestizo', 'descripcion' => 'Variado, único'],
        ];

        foreach ($razasGatos as $raza) {
            Raza::create([
                'especie_id' => $gato->id,
                'nombre' => $raza['nombre'],
                'descripcion' => $raza['descripcion'],
            ]);
        }

        // Tipos de aves
        $tiposAves = [
            ['nombre' => 'Canario', 'descripcion' => 'Pequeño, cantarín, amarillo'],
            ['nombre' => 'Periquito', 'descripcion' => 'Sociable, colorido, fácil cuidado'],
            ['nombre' => 'Loro', 'descripcion' => 'Inteligente, puede hablar, longevo'],
            ['nombre' => 'Ninfa', 'descripcion' => 'Cresta característica, sociable'],
        ];

        foreach ($tiposAves as $tipo) {
            Raza::create([
                'especie_id' => $ave->id,
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
            ]);
        }

        // Tipos de roedores
        $tiposRoedores = [
            ['nombre' => 'Hámster', 'descripcion' => 'Pequeño, nocturno, cachetes grandes'],
            ['nombre' => 'Conejo', 'descripcion' => 'Sociable, herbívoro, orejas largas'],
            ['nombre' => 'Cobayo', 'descripcion' => 'Dócil, vocal, sociable'],
            ['nombre' => 'Chinchilla', 'descripcion' => 'Pelaje suave, nocturna, activa'],
        ];

        foreach ($tiposRoedores as $tipo) {
            Raza::create([
                'especie_id' => $roedor->id,
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
            ]);
        }

        // Tipos de reptiles
        $tiposReptiles = [
            ['nombre' => 'Iguana', 'descripcion' => 'Herbívoro, arborícola, necesita calor'],
            ['nombre' => 'Gecko', 'descripcion' => 'Pequeño, nocturno, fácil manejo'],
            ['nombre' => 'Tortuga', 'descripcion' => 'Longeva, caparazón, tranquila'],
        ];

        foreach ($tiposReptiles as $tipo) {
            Raza::create([
                'especie_id' => $reptil->id,
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
            ]);
        }

        $this->command->info('✓ Especies y razas creadas correctamente');
    }
}
