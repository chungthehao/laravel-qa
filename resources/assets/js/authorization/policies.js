export default {
    modify(currentUser, model) { // model: question / answer
        return currentUser.id === model.user_id;
    },

    accept(currentUser, answer) {
        return currentUser.id === answer.question.user_id;
    }
}