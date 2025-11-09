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
            ['nombre' => 'Labrador Retriever', 'caracteristicas' => 'Amigable, enérgico, ideal para familias'],
            ['nombre' => 'Pastor Alemán', 'caracteristicas' => 'Inteligente, leal, buen guardián'],
            ['nombre' => 'Golden Retriever', 'caracteristicas' => 'Amable, confiable, gentil'],
            ['nombre' => 'Bulldog Francés', 'caracteristicas' => 'Juguetón, adaptable, sociable'],
            ['nombre' => 'Beagle', 'caracteristicas' => 'Curioso, amigable, excelente olfato'],
            ['nombre' => 'Poodle', 'caracteristicas' => 'Inteligente, activo, hipoalergénico'],
            ['nombre' => 'Chihuahua', 'caracteristicas' => 'Pequeño, valiente, leal'],
            ['nombre' => 'Yorkshire Terrier', 'caracteristicas' => 'Pequeño, enérgico, cariñoso'],
            ['nombre' => 'Mestizo', 'caracteristicas' => 'Variado, único'],
        ];

        foreach ($razasPerros as $raza) {
            Raza::create([
                'especie_id' => $perro->id,
                'nombre' => $raza['nombre'],
                'caracteristicas' => $raza['caracteristicas'],
            ]);
        }

        // Razas de gatos
        $razasGatos = [
            ['nombre' => 'Persa', 'caracteristicas' => 'Tranquilo, pelaje largo, cara achatada'],
            ['nombre' => 'Siamés', 'caracteristicas' => 'Vocal, sociable, elegante'],
            ['nombre' => 'Maine Coon', 'caracteristicas' => 'Grande, pelaje largo, amigable'],
            ['nombre' => 'Bengalí', 'caracteristicas' => 'Activo, patrón de leopardo, juguetón'],
            ['nombre' => 'Británico de Pelo Corto', 'caracteristicas' => 'Robusto, independiente, tranquilo'],
            ['nombre' => 'Ragdoll', 'caracteristicas' => 'Dócil, relajado, ojos azules'],
            ['nombre' => 'Mestizo', 'caracteristicas' => 'Variado, único'],
        ];

        foreach ($razasGatos as $raza) {
            Raza::create([
                'especie_id' => $gato->id,
                'nombre' => $raza['nombre'],
                'caracteristicas' => $raza['caracteristicas'],
            ]);
        }

        // Tipos de aves
        $tiposAves = [
            ['nombre' => 'Canario', 'caracteristicas' => 'Pequeño, cantarín, amarillo'],
            ['nombre' => 'Periquito', 'caracteristicas' => 'Sociable, colorido, fácil cuidado'],
            ['nombre' => 'Loro', 'caracteristicas' => 'Inteligente, puede hablar, longevo'],
            ['nombre' => 'Ninfa', 'caracteristicas' => 'Cresta característica, sociable'],
        ];

        foreach ($tiposAves as $tipo) {
            Raza::create([
                'especie_id' => $ave->id,
                'nombre' => $tipo['nombre'],
                'caracteristicas' => $tipo['caracteristicas'],
            ]);
        }

        // Tipos de roedores
        $tiposRoedores = [
            ['nombre' => 'Hámster', 'caracteristicas' => 'Pequeño, nocturno, cachetes grandes'],
            ['nombre' => 'Conejo', 'caracteristicas' => 'Sociable, herbívoro, orejas largas'],
            ['nombre' => 'Cobayo', 'caracteristicas' => 'Dócil, vocal, sociable'],
            ['nombre' => 'Chinchilla', 'caracteristicas' => 'Pelaje suave, nocturna, activa'],
        ];

        foreach ($tiposRoedores as $tipo) {
            Raza::create([
                'especie_id' => $roedor->id,
                'nombre' => $tipo['nombre'],
                'caracteristicas' => $tipo['caracteristicas'],
            ]);
        }

        // Tipos de reptiles
        $tiposReptiles = [
            ['nombre' => 'Iguana', 'caracteristicas' => 'Herbívoro, arborícola, necesita calor'],
            ['nombre' => 'Gecko', 'caracteristicas' => 'Pequeño, nocturno, fácil manejo'],
            ['nombre' => 'Tortuga', 'caracteristicas' => 'Longeva, caparazón, tranquila'],
        ];

        foreach ($tiposReptiles as $tipo) {
            Raza::create([
                'especie_id' => $reptil->id,
                'nombre' => $tipo['nombre'],
                'caracteristicas' => $tipo['caracteristicas'],
            ]);
        }

        $this->command->info('✓ Especies y razas creadas correctamente');
    }
}
