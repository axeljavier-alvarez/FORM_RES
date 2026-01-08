<x-interno-layout :breadcrumb="[
    [
      'name' => 'Dashboard',
      'url' => route('interno.consulta.index')
    ],
    [
    'name' => 'Analisis de documentos'
    ]
    
]">


@livewire('analisis-documentos-table')

</x-interno-layout>