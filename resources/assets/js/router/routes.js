import QuestionsPage from '../pages/QuestionsPage';
import QuestionPage from '../pages/QuestionPage';
import MyPostsPage from '../pages/MyPostsPage';

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
        name: 'questions.show' // ~ route's name in Laravel
    },
];

export default routes;