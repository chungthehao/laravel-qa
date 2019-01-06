export default {
    modify(currentUser, model) { // model: question / answer
        return currentUser.id === model.user_id;
    },

    accept(currentUser, answer) {
        return currentUser.id === answer.question.user_id;
    },

    deleteQuestion(currentUser, question) {
        return currentUser.id === question.user_id && question.answers_count < 1;
    }
}