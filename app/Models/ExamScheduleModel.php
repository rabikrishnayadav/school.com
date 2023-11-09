<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamScheduleModel extends Model
{
    use HasFactory;

    protected $table = 'exam_shedule';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecordSingle($exam_id, $class_id, $subject_id)
    {
        return ExamScheduleModel::where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->first();
    }

    static public function deleteRecord($exam_id, $class_id)
    {
        ExamScheduleModel::where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->delete();
    }

    static public function getExam($class_id)
    {
        \DB::statement("SET SQL_MODE=''");   // for groupBy('exam_id') if not work then uncomment it
        return ExamScheduleModel::select('exam_shedule.*', 'exam.name as exam_name')
                                    ->join('exam', 'exam.id', '=', 'exam_shedule.exam_id')
                                    ->where('exam_shedule.class_id', '=', $class_id)
                                    ->groupBy('exam_shedule.exam_id')
                                    ->orderBy('exam_shedule.id', 'desc')
                                    ->get();
    }

    static public function getExamTimetable($exam_id, $class_id)
    {
        return ExamScheduleModel::select('exam_shedule.*', 'subject.name as subject_name', 'subject.type as subject_type')
                                    ->join('subject', 'subject.id', '=', 'exam_shedule.subject_id')
                                    ->where('exam_shedule.exam_id', '=', $exam_id)
                                    ->where('exam_shedule.class_id', '=', $class_id)
                                    ->get();
    }

    static public function getSubject($exam_id, $class_id)
    {
        return ExamScheduleModel::select('exam_shedule.*', 'subject.name as subject_name', 'subject.type as subject_type')
                        ->join('subject', 'subject.id', '=', 'exam_shedule.subject_id')
                        ->where('exam_shedule.exam_id', '=', $exam_id)
                        ->where('exam_shedule.class_id', '=', $class_id)
                        ->get();
    }

    static public function getMyCalendarTeacher($teacher_id)
    {
        return ExamScheduleModel::select('exam_shedule.*', 'class.name as class_name', 'subject.name as subject_name', 'exam.name as exam_name')
                    ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'exam_shedule.class_id')
                    ->join('class', 'class.id', '=', 'exam_shedule.class_id')
                    ->join('subject', 'subject.id', '=', 'exam_shedule.subject_id')
                    ->join('exam', 'exam.id', '=', 'exam_shedule.exam_id')
                    ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
                    ->get();
    }


    static public function getMark($student_id, $exam_id, $class_id, $subject_id)
    {
        return MarksRegisterModel::CheckAlreadyMark($student_id, $exam_id, $class_id, $subject_id);
    }

    // for mark register teacher side
    static public function getExamTeacher($teacher_id)
    {
        \DB::statement("SET SQL_MODE=''");   // for groupBy('exam_id') if not work then uncomment it
        return ExamScheduleModel::select('exam_shedule.*', 'exam.name as exam_name')
                                    ->join('exam', 'exam.id', '=', 'exam_shedule.exam_id')
                                    ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'exam_shedule.class_id')
                                    ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
                                    ->groupBy('exam_shedule.exam_id')
                                    ->orderBy('exam_shedule.id', 'desc')
                                    ->get();
    }
}
