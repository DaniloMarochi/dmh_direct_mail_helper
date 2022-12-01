<?php

namespace App\Http\Livewire;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class studentEmailTable extends PowerGridComponent
{
    use ActionButton;

    public $frequence;
    public $occurrence;

    public string $email = '';

    public function setUp(): array {
        $this->showCheckBox();

        return [
            Exportable::make('export')->striped()->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns()->showSoftDeletes(),
            Footer::make()->showPerPage()->showRecordCount(),
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
        if($this->email != null && $this->email != ''){
            return Student::join('courses', 'students.course_id', '=', 'courses.id')
            ->select('students.*', 'courses.sigla as course')
            ->where('students.email', $this->email);

        }

        return redirect()->route('students.index')->with('error', 'Nenhum e-mail foi providenciado');
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
    public function relationSearch(): array {
        return [
            'course'
        ];
    }

    public function addColumns(): PowerGridEloquent {
        return PowerGrid::eloquent()
            ->addColumn('created_at_formatted', fn (Student $student) => Carbon::parse($student->created_at)->format('m/Y'))
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn('frequence')
            ->addColumn('occurrence')
            ->addColumn('course_formatted', fn (Student $student) => $student->course);
    }

    public function columns(): array {
        return [
            Column::make('Criado em', 'created_at_formatted', 'created_at')
                ->sortable()
                ->field('created_at_formatted', 'created_at')
                ->makeInputRange(),

            Column::make('Nome', 'name', 'name')
                ->sortable()
                ->field('name', 'name')
                ->searchable()
                ->makeInputText(),

            Column::make('E-mail', 'email', 'email')
                ->sortable()
                ->searchable()
                ->field('email', 'email')
                ->editOnClick(true)
                ->makeInputText(),

            Column::make('Frequência', 'frequence', 'frequence')
                ->sortable()
                ->makeInputRange()
                ->field('frequence', 'frequence')
                ->editOnClick(true)
                ->searchable(),

            Column::make('Ocorrência', 'occurrence', 'occurrence')
                ->sortable()
                ->field('occurrence', 'occurrence')
                ->editOnClick(true)
                ->searchable(),

            Column::make('Curso', 'course_formatted', 'courses.name')
                ->field('course_formatted', 'courses.name')
                ->sortable()->makeInputMultiSelect(Course::all(), 'name', 'course_id')

        ];
    }

    public function onUpdatedEditable(string $id, string $field, string $value): void {
        if ($field == 'email') {
            try {
                $updated = Student::query()->find($id)->update([
                    'email' => $value,
                ]);
            } catch (QueryException $exception) {
                $updated = false;
            }
        }

        if ($field == 'frequence') {
            try {
                $updated = Student::query()->find($id)->update([
                    'frequence' => $value,
                ]);
            } catch (QueryException $exception) {
                $updated = false;
            }
        }

        if ($field == 'occurrence') {
            try {
                $updated = Student::query()->find($id)->update([
                    'occurrence' => $value,
                ]);
            } catch (QueryException $exception) {
                $updated = false;
            }
        }

        if ($updated) {
            $this->fillData();
        }
    }
}
