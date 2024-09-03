<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
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

final class ExternalCompaniesTable extends PowerGridComponent
{
    use WithExport;

    public string $sortField = 'CompanyName';

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
        return ExternalCompanies::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('CompanyName')
            ->addColumn('AddressLine1')
            ->addColumn('Phone1')
            ->addColumn('Email')
            ->addColumn('location_link', function (ExternalCompanies $model) {
                return '<a href="#" wire:click.prevent="$dispatch(&apos;show-viewec-modal&apos;, { id: ' . e($model->ID) . '})">View</a> 
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-editec-modal&apos;, { id: ' . e($model->ID) . '})">Edit</a>
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-viewec-modal&apos;, { id: ' . e($model->ID) . '})">Delete</a>';
            });
    }

    #[\Livewire\Attributes\On('refresh-table')]
    public function columns(): array
    {
        return [
            Column::make('CompanyName', 'CompanyName')
                ->sortable()
                ->searchable(),

            Column::make('AddressLine1', 'AddressLine1')
                ->sortable()
                ->searchable(),

            Column::make('Phone1', 'Phone1')
                ->searchable(),

            Column::make('Email', 'Email')
                ->sortable()
                ->searchable(),

            Column::make('Link', 'location_link'),

            // Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::boolean('IsActive'),
            // Filter::inputText('CompanyName')->operators(['contains']),
            // Filter::inputText('Details')->operators(['contains']),
            // Filter::inputText('AddressLine1')->operators(['contains']),
            // Filter::inputText('AddressLine2')->operators(['contains']),
            // Filter::inputText('Phone1')->operators(['contains']),
            // Filter::inputText('Phone2')->operators(['contains']),
            // Filter::inputText('Email')->operators(['contains']),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    // public function actions(\App\Models\ExternalCompanies $row): array
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
