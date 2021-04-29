<?php

use App\Panel;
use Illuminate\Database\Seeder;

class PanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urls=[
            'https://distrowatch.com/',
            'https://www.horariodebrasilia.org/',
            'https://www.em.com.br/'
        ];

        $panel = Panel::create([
            'title' => 'Painel demonstrativo',
            'description' => 'Este é um painel apenas para cunho demonstrativo'
        ]);

        foreach ($urls as $url) {
            $panel->screen()->create([
                'url' => $url
            ]);
        }
    }
}
