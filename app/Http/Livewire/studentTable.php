<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class studentTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Student>
     */
    public function datasource(): Builder
    {
        return Student::join('courses', 'students.course_id', '=', 'courses.id')
            ->select('students.*', 'courses.sigla as course');

        //condicional da tela dos meses (nesse caso no mês de setembro)
        //->where('students.created_at', '>', date('2022-09-01'))
        //->where('students.created_at', '<', date('2022-10-01'));

        //condicional da tela de import
        //->where('students.created_at', '>', now('America/Sao_Paulo')->startOfDay());
        //->where('students.frequence', '<=', '75');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('name')

            /** Example of custom column using a closure **/
            ->addColumn('name_lower', function (Student $model) {
                return strtolower(e($model->name));
            })

            ->addColumn('email')
            ->addColumn('frequence')
            ->addColumn('occurrence')
            ->addColumn('course_formatted', fn (Student $student) => $student->course);
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->makeInputRange(),


            Column::make('Nome', 'name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('E-mail', 'email')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('Frequência', 'frequence')
                ->makeInputRange(),

            Column::make('Ocorrência', 'occurrence')
                ->sortable()
                ->searchable(),

            Column::make('Curso', 'course_formatted', 'courses.name')
                ->sortable()->makeInputMultiSelect(Course::all(), 'name', 'course_id')


        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Student Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {

        //$studentFrequence = Student::get('frequence')->toArray();

        return [
            Button::make('sendEmail', '<i class="fa-regular fa-envelope"></i>')
                ->class('btn btn-outline-warning cursor-pointer m-1 rounded text-sm')
                ->tooltip('Enviar email')
                ->route('students.send.email', ['id' => 'id'])
                ->target('_self'),

            Button::make('edit', '<i class="fas fa-edit"></i>')
                ->class('btn btn-outline-primary cursor-pointer m-1 rounded text-sm')
                ->tooltip('Edit Student')
                ->route('students.edit', ['id' => 'id'])
                ->target('_self'),

            Button::make('destroy', '<i class="fas fa-trash"></i>')
                ->class('btn btn-outline-danger cursor-pointer m-1 rounded text-sm')
                ->tooltip('Delete Student')
                ->route('students.destroy', ['id' => 'id'])
                ->method('patch')
                ->target('_self')
        ];
    }
}
