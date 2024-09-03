<?php

namespace App\Livewire;

use App\Models\Purchases;
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

final class PurchasesTable extends PowerGridComponent
{
    use WithExport;
    public string $sortField = 'Name';

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
        return Purchases::query()
            ->join('ExternalContactCompanies', 'ExternalPurchases.ExternalContactCompanyId', '=', 'ExternalContactCompanies.ID')
            ->join('ExternalPurchaseTypes', 'ExternalPurchases.ExternalPurchaseTypeId', '=', 'ExternalPurchaseTypes.ID')
            ->select('ExternalPurchases.*', 'ExternalContactCompanies.CompanyName as CompanyName', 'ExternalPurchaseTypes.Name as PTypeName');
    }

    public function relationSearch(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('refresh-table')]
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('Name')
            ->addColumn('IsActive')
            ->addColumn('PTypeName')
            ->addColumn('CompanyName')
            ->addColumn('actionlinks', function (Purchases $model) {
                return '<a href="#" wire:click.prevent="$dispatch(&apos;show-viewpurchase-modal&apos;, { id: ' . e($model->ID) . '})">View</a> 
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-editpurchase-modal&apos;, { id: ' . e($model->ID) . '})">Edit</a>
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-viewpurchase-modal&apos;, { id: ' . e($model->ID) . '})">Delete</a>';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'Name')
                ->sortable()
                ->searchable(),

            Column::make('Company Name', 'CompanyName'),
            Column::make('Purchase Type', 'PTypeName'),
            Column::make('Active', 'IsActive'),
            Column::make('Actions', 'actionlinks')

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

    // public function actions(\App\Models\Purchases $row): array
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
