export default {
    modify(currentUser, model) { // model: question / answer
        return currentUser.id === model.user.id;
    },

    accept(currentUser, answer) {
        return currentUser.id === answer.question_user_id;
    },

    deleteQuestion(currentUser, question) {
        return currentUser.id === question.user.id && question.answers_count < 1;
    }
}