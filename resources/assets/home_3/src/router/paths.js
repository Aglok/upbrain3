/**
 * Define all of your application routes here
 * for more information on routes, see the
 * official documentation https://router.vuejs.org/en/
 */
export default [
  {
    path: '/',
    // Relative to /src/views
    view: 'UserProfile/Main',
    redirect: '/profile'
  },
  {
    path: '/profile',
    name: 'Main',
    view: 'UserProfile/Main',
  },
  {
    path: '/profile-test',
    name: 'User Profile',
    view: 'UserProfile/DollPanelUser'
  },
  {
    path: '/table_tasks/:mission_id',
    name: 'Table Tasks',
    view: 'UserProfile/TableTasks',
  },
  {
    path: '/table_exam',
    name: 'Table Exam',
    view: 'TableExam',
  },
  {
    path: '/table-exam-result/:id',
    name: 'Table Exam Result',
    view: 'TableExamResult'
  },
  {
    path: '/notifications',
    name: 'Notification',
    view: 'Notifications'
  },
  {
    path: '/battle/:subject?/:mission_id?',
    name: 'Battle',
    view: 'Battle'
  }
]
