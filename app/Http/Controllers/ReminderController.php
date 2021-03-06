<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Reaction;
use App\Models\Evaluation;
use App\Models\InstantUser;
use App\Models\Task;
use App\Models\TaskContent;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Session\Session;
use Validator;

class ReminderController extends Controller
{
    public function Reminder()
    {
        return view('yrm/Reminder', ['first_visit' => Session('first_visit')]);
    }

    public function AdminEditor()
    {
        return view('yrm/AdminEditor');
    }

    public function LoadTable()
    {
        $t = Reaction::leftJoin('evaluations', 'reactions.evaluation_id', '=', 'evaluations.id')
            ->select('reactions.id', 'evaluation', 'subject', 'text')->get();

        return [
            ['dsfjoij' => 'sjdfi'],
            ['dsfjoij' => 'sjdfi'],
            ['dsfjoij' => 'sjdfi'],
            ['dsfjoij' => 'sjdfi'],
        ];
    }

    public function ReactionsTable()
    {
        return view('yrm/ReactionsTable');
    }

    public function LoadReactionsTable()
    {
        $table = Reaction::select('reactions.id', 'evaluation_id', 'subject', 'text')->get();
        return [
            'table' => $table,
            'sub' => [
                Evaluation::select('id', 'evaluation')->get(),
                Evaluation::select('id', 'evaluation')->get(),
            ],
        ];
    }

    public function LoadEvaluationsTable()
    {
        $table = Evaluation::select('id', 'evaluation')->get();
        return [
            'table' => $table,
            'sub' => [
                null,
            ],
        ];
    }

    public function LoadTaskContentsTable()
    {
        $table = TaskContent::select('id', 'limit_span', 'time_notice', 'subject', 'memo')->get();
        return [
            'table' => $table,
            'sub' => [
                null,
            ],
        ];
    }

    public function LoadTasksTable()
    {
        $table = Task::select('id', 'user_id', 'user_task_id', 'limits', 'content_id', 'evaluation_id')->get();

        return [
            'table' => $table,
            'sub' => [
                'InstantUser' => InstantUser::select('id', 'name')->get(),
                'TaskContent'=> TaskContent::select('id', 'subject', 'memo', 'limit_span', 'time_notice')->get(),
                'Evaluation' => Evaluation::select('id', 'evaluation')->get(),
            ],
        ];
    }

    private function ToMin($time){
        $tArry=explode(":",$time);
        $hour=$tArry[0]*60;//????????????
        $secnd=round($tArry[2]/60,2);//?????????????????????2???????????????
        $mins=$hour+$tArry[1]+$secnd;//??????????????????
        return $mins;
        }

    private function TaskJoinedTable() {
        
        $table = Task::where([
            ['archived', 0],
            ['instant_id', session('iid')],
        ])
            ->leftJoin('instant_users', 'tasks.user_id', '=', 'instant_users.id')
            ->leftJoin('task_contents', 'tasks.content_id', '=', 'task_contents.id')
            ->leftJoin('evaluations', 'tasks.evaluation_id', '=', 'evaluations.id')
            ->select('tasks.id as task_id', 'subject as ??????', 'memo as ??????', 'limits as ???', 'limits as ???', 'time_notice as ??????')->get();

        return $table;
    }

    public function GetReminder()
    {
        $table = $this->TaskJoinedTable();

        foreach($table as $row) {
            /* ???????????? ?????? */
            $min = $this->ToMin($row->??????);
            $row->?????? = "$min ??????";

            /* ????????????????????? */
            
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, $row->???);
            $row->??? = $date->format('Y/m/d');
            $row->??? = $date->format('A g:i');
        }

        return [
            'table' => $table,
            'trust_point' => InstantUser::where('instant_id', session('iid'))->first()->trust_point,
        ];
    }

    public function AddTask() 
    {
        $task = new Task();

        /* ??????????????????????????? */
        $task->user_id = InstantUser::where('instant_id', session('iid'))->first()->id;
        
        /* ??????????????????????????????????????? */
        $task->content_id = random_int(1, TaskContent::all()->count());
        
        /* ???????????????????????????????????????????????? */
        $l = 0;
        while (Task::where('user_id', $task->content_id)->where('content_id', $task->content_id)->exists()) {
            $task->content_id = random_int(1, TaskContent::all()->count());
            $l++;
            if ($l > 30) return $this->GetReminder(); 
        }

        $task->user_task_id = Task::where('user_id', $task->user_id)->get()->count();
        $task->archived = 0;
        $task->evaluation_id = 1;

        /* time_span????????????????????? */
        $span = $this->ToMin(TaskContent::find($task->content_id)->limit_span);
        $task->limits = Carbon::now()->addminute($span);

        $task->save();

        return $this->GetReminder();
    }

    public function DeleteTask(Request $req)
    {
        $task_id = $req->input('task_id');
        Task::where('tasks.id', $task_id)->update(['archived' => 1]);
        return null;
    }

    public function GetEvaluateNotice(Request $req)
    {
        $task_id = $req->input('task_id');
        $table = Task::where('tasks.id', $task_id)->leftJoin('instant_users', 'tasks.user_id', '=', 'instant_users.id')
        ->leftJoin('task_contents', 'tasks.content_id', '=', 'task_contents.id')
        ->leftJoin('evaluations', 'tasks.evaluation_id', '=', 'evaluations.id')
        ->select('tasks.id as task_id', 'subject as ??????', 'memo as ??????', 'limits as ???', 'time_notice as ??????', 'trust_point', 'instant_users.id as userID')->first();
        // $table = $this->TaskJoinedTable()->first();

        /* ??????????????????????????????????????????????????????????????? */
        $limitTime = new Carbon($table->???);
        $noticeTime = $limitTime;
        $noticeTime->subMinute($this->ToMin($table->??????));
        $serverTime = new Carbon();
        $serverTime = Carbon::now();

        $diff = $serverTime->diffInMinutes($noticeTime);

        /* ??????????????????????????????????????? */
        if ($serverTime->lt($noticeTime)) $diff *= -1;

        /* ----- ?????????????????? ----------------------- */
        /*  ??????????????????30???????????????  */
        if ($diff > $this->ToMin($table->??????) + 30) {
            $evaluation = Evaluation::find(8);
            $trust = $table->trust_point - 45;
        }
        else if ($diff > 10) {
            $evaluation = Evaluation::find(7);
            $trust = $table->trust_point - 10;
        }
        else if ($diff > $this->ToMin($table->??????) * 3 / 4) {
            $evaluation = Evaluation::find(6);
            $trust = $table->trust_point - 5;
        }
        else if ($diff > 1) {
            $evaluation = Evaluation::find(3);
            $trust = $table->trust_point - 2;
        }
        else if ($diff > -1) {
            $evaluation = Evaluation::find(2);
            $trust = $table->trust_point + 10;
        }
        else if ($diff > $this->ToMin($table->??????) * 3 / -4) {
            $evaluation = Evaluation::find(3);
            $trust = $table->trust_point + 1;
        }
        else if ($diff > -20) {
            $evaluation = Evaluation::find(4);
            $trust = $table->trust_point - 4;
        }
        else  {
            $evaluation = Evaluation::find(5);
            $trust = $table->trust_point - 8;
        }

        $reaction = Reaction::where('evaluation_id', $evaluation->id)->first();
        $reaction->text = nl2br($reaction->text); /* ??????????????????????????? */

        /* archive */
        if ($diff >  $this->ToMin($table->??????) * 3 / -4) {
            Task::where('tasks.id', $task_id)->update(['archived' => 1]);
        }
        
        /* ??????????????? */
        $gameover = false;
        $gameclear = false;
        if ($trust <= 0) {
            $trust = 0;
            $gameover = true;
        }
        if ($trust >= 100) {
            $trust = 100;
            $gameclear = true;
        }

        InstantUser::find($table->userID)->update(['trust_point' => $trust]);

        return [
            'evaluation' => $evaluation,
            'reaction' => $reaction,
            'diff' => $diff,
            'game_over' => $gameover,
            'game_clear' => $gameclear,
        ];
    }

    public function UpdateTable(Request $req)
    {
        $row = $req->rowData;
        $table = $req->tableName;

        switch ($table) {
            case 'Reactions':
                // $validated = $row->validate([
                //     [
                //         'evaluation_id' => 'bail|required',
                //         'subject' => 'required',
                //     ],
                // ]);
                
                Reaction::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'evaluation_id' => $row['evaluation_id'],
                        'subject' => $row['subject'],
                        'text' => $row['text'],
                    ],
                );

                return $this->LoadReactionsTable();

            case 'Evaluations':
                Evaluation::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'evaluation' => $row['evaluation'],
                    ],
                );

                return $this->LoadEvaluationsTable();

            case 'TaskContents':
                TaskContent::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'limit_span' => $row['limit_span'],
                        'time_notice' => $row['time_notice'],
                        'subject' => $row['subject'],
                        'memo' => $row['memo'],
                    ],
                );

                return $this->LoadTaskContentsTable();


            case 'Tasks':
                Task::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'user_id' => $row['user_id'],
                        'user_task_id' => $row['user_task_id'],
                        'content_id' => $row['content_id'],
                        'evaluation_id' => $row['evaluation_id'],
                        'limits' => $row['limits'],
                    ],
                );

                return $this->LoadTasksTable();

            default:
                break;
        }
    }
}
