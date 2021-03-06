<?php


namespace App\Services;


use App\Models\Answer;

class AnswerService
{
    public function __construct()
    {
    }

    /**
     * 아이디로 답변 찾기
     *
     * @param $id
     * @return mixed
     */
    public function getAnswerById($id)
    {
        return Answer::findOrFail($id);
    }

    /**
     * 질문 아이디의 모든 답변
     *
     * @param $id
     * @return mixed
     */
    public function getAnswersByQuestionId($id)
    {
        return Answer::where('question_id', $id)->get();
    }

    /**
     * 해당 고양이의 모든 답변 가져오기
     *
     * @param $id
     * @return mixed
     */
    public function getAnswersByUserId($id)
    {
        return Answer::where('user_id', $id)->get();
    }

    /**
     * 답변마다 해당 유저 가져오기
     *
     * @param $answers
     * @return mixed
     */
    public function getAnswersWithUser($answers)
    {
        foreach($answers as $answer)
        {
            $answer->user->age = null;
            $answer->user->kind = $answer->user->kind->name;
            $answer->user->color = $answer->user->color->name;
        }

        return $answers;
    }

    /**
     * 답변 생성
     *
     * @param $request
     * @param $question_id
     * @return Answer
     */
    public function create($request, $question_id)
    {
        $answer = new Answer();

        $answer->fill($request->all());
        $answer->question_id = $question_id;
        $answer->user_id = $request->user()->id;

        $answer->save();

        return $answer;
    }

    /**
     * 답변 수정
     *
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        $question = $this->getAnswerById($id);
        $question->update($request->all());
    }

    /**
     * 답변 삭제
     *
     * @param $id
     */
    public function delete($id)
    {
        $question = $this->getAnswerById($id);
        $question->delete();
    }
}
