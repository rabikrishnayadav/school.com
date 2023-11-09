<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\HomeworkSubmitModel;
use Request;

class HomeworkModel extends Model
{
    use HasFactory;

    protected $table = 'homework';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = HomeworkModel::select('homework.*', 'class.name as class_name', 'subject.name as subject_name', 'users.name as created_by_name')
                    ->join('users', 'users.id', '=', 'homework.created_by')
                    ->join('class', 'class.id', '=', 'homework.class_id')
                    ->join('subject', 'subject.id', '=', 'homework.subject_id')
                    ->where('homework.is_delete', '=', 0);

                    if (!empty(Request::get('class_name')))
                    {
                        $return = $return->where('class.name', 'like', '%'.Request::get('class_name').'%');
                    }

                    if (!empty(Request::get('subject_name')))
                    {
                        $return = $return->where('subject.name', 'like', '%'.Request::get('subject_name').'%');
                    }


                    if (!empty(Request::get('from_homework_date')))
                    {
                        $return = $return->where('homework.homework_date', '>=', Request::get('from_homework_date'));
                    }

                    if (!empty(Request::get('to_homework_date')))
                    {
                        $return = $return->where('homework.homework_date', '<=', Request::get('to_homework_date'));
                    }

                    if (!empty(Request::get('from_submission_date')))
                    {
                        $return = $return->where('homework.submission_date', '>=', Request::get('from_submission_date'));
                    }

                    if (!empty(Request::get('to_submission_date')))
                    {
                        $return = $return->where('homework.submission_date', '<=', Request::get('to_submission_date'));
                    }

                    if (!empty(Request::get('from_created_date')))
                    {
                        $return = $return->whereDate('homework.created_at', '>=', Request::get('from_created_date'));
                    }

                    if (!empty(Request::get('to_created_date')))
                    {
                        $return = $return->whereDate('homework.created_at', '<=', Request::get('to_created_date'));
                    }
                    
        $return = $return->orderBy('homework.id', 'desc')
                    ->paginate(20);

        return $return;
    }

    static public function getHomeworkRecord()
    {
        $return = HomeworkSubmitModel::select('homework_submit.*', 'class.name as class_name', 'subject.name as subject_name', 'users.name as first_name', 'users.last_name as last_name')
                    ->join('users', 'users.id', '=', 'homework_submit.student_id')
                    ->join('homework', 'homework.id', '=', 'homework_submit.homework_id')
                    ->join('class', 'class.id', '=', 'homework.class_id')
                    ->join('subject', 'subject.id', '=', 'homework.subject_id');


                    if (!empty(Request::get('first_name')))
                    {
                        $return = $return->where('users.name', 'like', '%'.Request::get('first_name').'%');
                    }

                    if (!empty(Request::get('last_name')))
                    {
                        $return = $return->where('users.last_name', 'like', '%'.Request::get('last_name').'%');
                    }

                    if (!empty(Request::get('class_name')))
                    {
                        $return = $return->where('class.name', 'like', '%'.Request::get('class_name').'%');
                    }

                    if (!empty(Request::get('subject_name')))
                    {
                        $return = $return->where('subject.name', 'like', '%'.Request::get('subject_name').'%');
                    }


                    if (!empty(Request::get('from_homework_date')))
                    {
                        $return = $return->where('homework.homework_date', '>=', Request::get('from_homework_date'));
                    }

                    if (!empty(Request::get('to_homework_date')))
                    {
                        $return = $return->where('homework.homework_date', '<=', Request::get('to_homework_date'));
                    }

                    if (!empty(Request::get('from_submission_date')))
                    {
                        $return = $return->where('homework.submission_date', '>=', Request::get('from_submission_date'));
                    }

                    if (!empty(Request::get('to_submission_date')))
                    {
                        $return = $return->where('homework.submission_date', '<=', Request::get('to_submission_date'));
                    }

                    if (!empty(Request::get('from_created_date')))
                    {
                        $return = $return->whereDate('homework.created_at', '>=', Request::get('from_created_date'));
                    }

                    if (!empty(Request::get('to_created_date')))
                    {
                        $return = $return->whereDate('homework.created_at', '<=', Request::get('to_created_date'));
                    }
                    

        $return = $return->orderBy('homework.id', 'desc')
                    ->paginate(20);

        return $return;
    }

    public function getDocument()
    {
        if (!empty($this->document_file) && file_exists('upload/homework/'.$this->document_file))
        {
            return url('upload/homework/'.$this->document_file);
        }
        else
        {
            return "";
        }
    }

    static public function getRecordTeacher($class_id)
    {
        $return = HomeworkModel::select('homework.*', 'class.name as class_name', 'subject.name as subject_name', 'users.name as created_by_name')
                    ->join('users', 'users.id', '=', 'homework.created_by')
                    ->join('class', 'class.id', '=', 'homework.class_id')
                    ->join('subject', 'subject.id', '=', 'homework.subject_id')
                    ->whereIn('homework.class_id', $class_id)
                    ->where('homework.is_delete', '=', 0);

                    if (!empty(Request::get('class_name')))
                    {
                        $return = $return->where('class.name', 'like', '%'.Request::get('class_name').'%');
                    }

                    if (!empty(Request::get('subject_name')))
                    {
                        $return = $return->where('subject.name', 'like', '%'.Request::get('subject_name').'%');
                    }


                    if (!empty(Request::get('from_homework_date')))
                    {
                        $return = $return->where('homework.homework_date', '>=', Request::get('from_homework_date'));
                    }

                    if (!empty(Request::get('to_homework_date')))
                    {
                        $return = $return->where('homework.homework_date', '<=', Request::get('to_homework_date'));
                    }

                    if (!empty(Request::get('from_submission_date')))
                    {
                        $return = $return->where('homework.submission_date', '>=', Request::get('from_submission_date'));
                    }

                    if (!empty(Request::get('to_submission_date')))
                    {
                        $return = $return->where('homework.submission_date', '<=', Request::get('to_submission_date'));
                    }

                    if (!empty(Request::get('from_created_date')))
                    {
                        $return = $return->whereDate('homework.created_at', '>=', Request::get('from_created_date'));
                    }

                    if (!empty(Request::get('to_created_date')))
                    {
                        $return = $return->whereDate('homework.created_at', '<=', Request::get('to_created_date'));
                    }
                    
        $return = $return->orderBy('homework.id', 'desc')
                    ->paginate(20);

        return $return;
    }

    static public function getRecordStudent($class_id, $student_id)
    {
        $return = HomeworkModel::select('homework.*', 'class.name as class_name', 'subject.name as subject_name', 'users.name as created_by_name')
                    ->join('users', 'users.id', '=', 'homework.created_by')
                    ->join('class', 'class.id', '=', 'homework.class_id')
                    ->join('subject', 'subject.id', '=', 'homework.subject_id')
                    ->where('homework.class_id', '=', $class_id)
                    ->where('homework.is_delete', '=', 0)
                    
                    ->whereNotIn('homework.id', function($query) use ($student_id) {
                        $query->select('homework_submit.homework_id')
                                ->from('homework_submit')
                                ->where('homework_submit.student_id', '=', $student_id);
                    });

                    if (!empty(Request::get('class_name')))
                    {
                        $return = $return->where('class.name', 'like', '%'.Request::get('class_name').'%');
                    }

                    if (!empty(Request::get('subject_name')))
                    {
                        $return = $return->where('subject.name', 'like', '%'.Request::get('subject_name').'%');
                    }


                    if (!empty(Request::get('from_homework_date')))
                    {
                        $return = $return->where('homework.homework_date', '>=', Request::get('from_homework_date'));
                    }

                    if (!empty(Request::get('to_homework_date')))
                    {
                        $return = $return->where('homework.homework_date', '<=', Request::get('to_homework_date'));
                    }

                    if (!empty(Request::get('from_submission_date')))
                    {
                        $return = $return->where('homework.submission_date', '>=', Request::get('from_submission_date'));
                    }

                    if (!empty(Request::get('to_submission_date')))
                    {
                        $return = $return->where('homework.submission_date', '<=', Request::get('to_submission_date'));
                    }

                    if (!empty(Request::get('from_created_date')))
                    {
                        $return = $return->whereDate('homework.created_at', '>=', Request::get('from_created_date'));
                    }

                    if (!empty(Request::get('to_created_date')))
                    {
                        $return = $return->whereDate('homework.created_at', '<=', Request::get('to_created_date'));
                    }
                    
        $return = $return->orderBy('homework.id', 'desc')
                    ->paginate(20);

        return $return;
    }

    static public function getRecordStudentCount($class_id, $student_id)
    {
        $return = HomeworkModel::select('homework.id')
                    ->join('users', 'users.id', '=', 'homework.created_by')
                    ->join('class', 'class.id', '=', 'homework.class_id')
                    ->join('subject', 'subject.id', '=', 'homework.subject_id')
                    ->where('homework.class_id', '=', $class_id)
                    ->where('homework.is_delete', '=', 0)
                    
                    ->whereNotIn('homework.id', function($query) use ($student_id) {
                        $query->select('homework_submit.homework_id')
                                ->from('homework_submit')
                                ->where('homework_submit.student_id', '=', $student_id);
                    });

        $return = $return->orderBy('homework.id', 'desc')
                    ->count();

        return $return;
    }

}
