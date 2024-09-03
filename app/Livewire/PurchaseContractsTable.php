<?php

namespace App\Livewire;

use App\Models\PurchaseContracts;
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

final class PurchaseContractsTable extends PowerGridComponent
{
    use WithExport;


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
        return PurchaseContracts::query();
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
            ->addColumn('FileNumber')
            ->addColumn('StartDate_formatted', fn (PurchaseContracts $model) => Carbon::parse($model->StartDate)->format('d/m/Y'))
            ->addColumn('EndDate_formatted', fn (PurchaseContracts $model) => Carbon::parse($model->EndDate)->format('d/m/Y'))
            ->addColumn('actionlinks', function (PurchaseContracts $model) {
                return '<a href="#" wire:click.prevent="$dispatch(&apos;show-viewpc-modal&apos;, { id: ' . e($model->ID) . '})">View</a> 
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-editpc-modal&apos;, { id: ' . e($model->ID) . '})">Edit</a>
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-viewpc-modal&apos;, { id: ' . e($model->ID) . '})">Delete</a>';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'Name')
                ->sortable()
                ->searchable(),

            Column::make('FileNumber', 'FileNumber')
                ->sortable()
                ->searchable(),

            Column::make('StartDate', 'StartDate_formatted', 'StartDate')
                ->sortable(),

            Column::make('EndDate', 'EndDate_formatted', 'EndDate')
                ->sortable(),

            Column::make('Actions', 'actionlinks')
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('Name')->operators(['contains']),
            // Filter::inputText('Details')->operators(['contains']),
            // Filter::inputText('FileNumber')->operators(['contains']),
            // Filter::inputText('FileName')->operators(['contains']),
            // Filter::inputText('OnlineLocation')->operators(['contains']),
            // Filter::boolean('IsPerpetual'),
            // Filter::datetimepicker('StartDate'),
            // Filter::datetimepicker('EndDate'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    // public function actions(\App\Models\PurchaseContracts $row): array
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
