<?php


namespace App\Services;


use App\Models\Question;

class QuestionService extends Service
{

    /**
     * 아이디를 통해 질문 가져오기
     *
     * @param $id
     * @return Question
     */
    public function getQuestionById($id)
    {
        return $this->getQuestionByIdQuery($id)->first();
    }

    /**
     * 아이디를 통해 질문 쿼리빌더로 가져오기
     *
     * @param $id
     * @return mixed
     */
    public function getQuestionByIdQuery($id)
    {
        return Question::where('id', $id);
    }

    /**
     * 질문 아이디를 통해 질문과 답변 모두 가져오기
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getQuestionByIdWithAnswer($id)
    {
        return $this->getQuestionById($id)->with('answer')->get();
    }

    /**
     * 사용자의 모든 질문 리스트 가져오기
     *
     * @param $id
     * @return Question
     */
    public function getAllQuestionsByUserId($id)
    {
        return Question::where('user_id', $id)->get();
    }

    /**
     * 질문과 질문자 가져오기
     *
     * @param $id
     * @return Question
     */
    public function getQuestionWithUser($id)
    {
        $question = $this->getQuestionById($id);

        $question->user->kind = $question->user->kind->name;
        $question->user->color = $question->user->color->name;
        $question->user->age = null;

        return $question;
    }

    /**
     * 질문 등록하기
     *
     * @param $request
     * @return Question
     */
    public function create($request)
    {
        $question = new Question();

        $question->fill($request->all());

        $question->user_id = auth()->user()->id;

        $question->save();

        return $question;
    }

    /**
     * 질문 수정하기
     *
     * @param $request
     */
    public function update($request, $id)
    {
        $question = $this->getquestionById($id);
        $question->update($request->all());
    }

    /**
     * 질문 삭제하기
     *
     * @param $id
     */
    public function delete($id)
    {
        $question = $this->getQuestionById($id);
        $question->delete();
    }

}
