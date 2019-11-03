import QuestionsPage from '../pages/QuestionsPage';
import CreateQuestionPage from '../pages/CreateQuestionPage';
import EditQuestionPage from '../pages/EditQuestionPage';
import QuestionPage from '../pages/QuestionPage';
import MyPostsPage from '../pages/MyPostsPage';
import NotFoundPage from '../pages/NotFoundPage';

const routes = [
    {
        path: '/',
        component: QuestionsPage, // ~ blade view in Laravel
        name: 'home' // ~ route's name in Laravel
    },
    {
        path: '/questions',
        component: QuestionsPage, // ~ blade view in Laravel
        name: 'questions' // ~ route's name in Laravel
    },
    {
        path: '/questions/create',
        component: CreateQuestionPage, // ~ blade view in Laravel
        name: 'questions.create' // ~ route's name in Laravel
    },
    {
        path: '/questions/:id/edit',
        component: EditQuestionPage, // ~ blade view in Laravel
        name: 'questions.edit' // ~ route's name in Laravel
    },
    {
        path: '/my-posts',
        component: MyPostsPage, // ~ blade view in Laravel
        name: 'my-posts', // ~ route's name in Laravel
        meta: {
            requiresAuth: true // https://router.vuejs.org/guide/advanced/meta.html
        }
    },
    {
        path: '/questions/:slug', // ~ {slug} in Laravel
        component: QuestionPage, // ~ blade view in Laravel
        name: 'questions.show', // ~ route's name in Laravel

        // - Cái slug ở trên URL sẽ truyền thành props cho QuestionPage
        // - Khỏi cần lấy bằng cách: this.$route.params.slug
        props: true
    },
    {
        path: '*',
        component: NotFoundPage, // ~ blade view in Laravel
        name: 'not-found' // ~ route's name in Laravel
    },

];

export default routes;