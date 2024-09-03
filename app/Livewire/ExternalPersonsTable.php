<?php

namespace App\Livewire;

use App\Models\ExternalPersons;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class ExternalPersonsTable extends PowerGridComponent
{
    use WithExport;

    public string $sortField = 'FirstName';

    public function setUp(): array
    {

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return ExternalPersons::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('refresh-table')]
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('FirstName')
            ->addColumn('LastName')
            ->addColumn('Phone1')
            ->addColumn('Email')
            ->addColumn('IsActive')
            ->addColumn('location_link', function (ExternalPersons $model) {
                return '<a href="#" wire:click.prevent="$dispatch(&apos;show-viewep-modal&apos;, { id: ' . e($model->ID) . '})">View</a> 
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-editep-modal&apos;, { id: ' . e($model->ID) . '})">Edit</a>
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-viewep-modal&apos;, { id: ' . e($model->ID) . '})">Delete</a>';
            });;
    }

    public function columns(): array
    {
        return [
            Column::make('FirstName', 'FirstName')
                ->sortable()
                ->searchable(),

            Column::make('LastName', 'LastName')
                ->sortable()
                ->searchable(),

            Column::make('Phone1', 'Phone1')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'Email')
                ->sortable()
                ->searchable(),

            Column::make('IsActive', 'IsActive'),

            Column::make('Link', 'location_link'),


        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    // public function actions(\App\Models\ExternalPersons $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: ' . $row->id)
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
