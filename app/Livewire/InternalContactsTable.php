<?php

namespace App\Livewire;

use App\Models\InternalContacts;
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

final class InternalContactsTable extends PowerGridComponent
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
        return InternalContacts::query()
            ->join('BusinessGroups', 'InternalContacts.BusinessGroupId', '=', 'BusinessGroups.ID')
            ->join('MOHRoles', 'InternalContacts.MOHRoleId', '=', 'MOHRoles.ID')
            ->select('InternalContacts.*', 'BusinessGroups.ID as BGID', 'BusinessGroups.Name as DepartmentName', 'MOHRoles.ID as RoleID', 'MOHRoles.Name as RoleName');

        // return InternalContacts::query()
        //     ->join('BusinessGroups', function ($department) {
        //         $department->on('InternalContacts.BusinessGroupId', '=', 'BusinessGroups.ID');
        //     })
        //     ->select([
        //         'InternalContacts.*',
        //         'BusinessGroups.ID as BGID',
        //         'BusinessGroups.Name as DepartmentName',
        //     ]);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('FirstName')
            ->addColumn('LastName')
            ->addColumn('Email')
            ->addColumn('PhoneExt')
            ->addColumn('DepartmentName')
            ->addColumn('RoleName')
            ->addColumn('location_link', function (InternalContacts $model) {
                return '<a href="#" wire:click.prevent="$dispatch(&apos;show-viewic-modal&apos;, { id: ' . e($model->ID) . '})">View</a> 
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-editic-modal&apos;, { id: ' . e($model->ID) . '})">Edit</a>
                | <a href="#" wire:click.prevent="$dispatch(&apos;show-viewic-modal&apos;, { id: ' . e($model->ID) . '})">Delete</a>';
            });
    }

    #[\Livewire\Attributes\On('refresh-table')]
    public function columns(): array
    {
        return [

            Column::make('First Name', 'FirstName')
                ->sortable()
                ->searchable(),

            Column::make('Last Name', 'LastName')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'Email')
                ->sortable()
                ->searchable(),

            Column::make('Phone Ext', 'PhoneExt')
                ->sortable()
                ->searchable(),

            Column::make('Department', 'DepartmentName', 'BusinessGroups.Name')
                ->sortable()
                ->searchable(),

            Column::make('Role', 'RoleName', 'MOHRoles.Name')
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
            // Filter::inputText('FirstName')->operators(['contains']),
            // Filter::inputText('LastName')->operators(['contains']),
            // Filter::inputText('Email')->operators(['contains']),
            // Filter::inputText('PhoneExt')->operators(['contains']),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    // public function actions(\App\Models\InternalContacts $row): array
    // {
    //     return [
    //         Button::add('view')
    //             ->slot('View')
    //             ->class('btn btn-primary cursor-pointer text-white px-3 rounded text-sm')
    //             ->dispatch('show-viewic-modal', ['id' => $row->ID]),


    //         Button::add('edit')
    //             ->slot('Edit')
    //             ->class('btn btn-primary cursor-pointer text-white px-3 rounded text-sm')
    //             ->dispatch('show-viewic-modal', ['id' => $row->ID])
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
