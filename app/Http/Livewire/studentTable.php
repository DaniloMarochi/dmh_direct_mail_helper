<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};


final class StudentTable extends PowerGridComponent {
    use ActionButton;

    public $email;
    public $frequence;
    public $occurrence;

    public string $year = '';
    public string $month = '';

    public function setUp(): array {
        $this->showCheckBox();

        return [
            Exportable::make('export')->striped()->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns()->showSoftDeletes(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder {
        if ($this->year != '' && $this->month != '') {
            Carbon::setLocale('pt_BR');

            $date = Carbon::createFromDate($this->year, $this->month, 1, 'America/Sao_Paulo');

            $start = $date->startOfMonth()->toDateTimeString();
            $end = $date->endOfMonth()->toDateTimeString();

            return Student::join('courses', 'students.course_id', '=', 'courses.id')
                ->select('students.*', 'courses.sigla as course')
                ->whereBetween('students.created_at', [$start, $end]);
        }

        return Student::join('courses', 'students.course_id', '=', 'courses.id')
            ->select('students.*', 'courses.sigla as course')
            ->where('students.created_at', '>', now('America/Sao_Paulo')->startOfDay());
    }

    public function relationSearch(): array {
        return [
            'course'
        ];
    }

    public function addColumns(): PowerGridEloquent {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn('frequence')
            ->addColumn('occurrence')
            ->addColumn('course_formatted', fn (Student $student) => $student->course);
    }

    public function columns(): array {
        return [
            Column::make('ID', 'id', 'id')
                ->sortable()
                ->field('id')
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

    public function actions(): array {
        return [
            Button::make('sendEmail', '<i class="fa-regular fa-envelope"></i>')
                ->class('btn btn-outline-warning cursor-pointer m-1 rounded text-sm')
                ->tooltip('Enviar email')
                ->route('students.send.email', ['id' => 'id'])
                ->target('_self'),

            Button::make('destroy', '<i class="fas fa-trash"></i>')
                ->class('btn btn-outline-danger cursor-pointer m-1 rounded text-sm')
                ->tooltip('Deletar Estudante')
                ->route('students.destroy', ['id' => 'id'])
                ->method('patch')
                ->target('_self'),

            Button::make('restoreStudent', '<i class="fa-solid fa-trash-arrow-up"></i>')
                ->class('btn btn-outline-warning cursor-pointer m-1 rounded text-sm')
                ->tooltip('Restaurar Estudante')
                ->route('students.restore', ['id' => 'id'])
                ->method('patch')
                ->target('_self'),
        ];
    }

    public function actionRules(): array {
        return [
            Rule::button('sendEmail')
                ->when(fn ($student) => ($student->frequence > 75 || $student->mailed || $student->deleted_at))
                ->hide(),

            Rule::button('destroy')
                ->when(fn ($student) => $student->deleted_at != null)
                ->hide(),

            Rule::button('restoreStudent')
                ->when(fn ($student) => $student->deleted_at == null)
                ->hide()
        ];
    }
}
