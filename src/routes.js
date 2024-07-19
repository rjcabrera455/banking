import AppLayout from '@/layout/AppLayout.vue';

export default [
    {
        path: '/',
        component: AppLayout,
        children: [
            {
                path: '/',
                name: 'dashboard',
                meta: { requiresAuth: true },
                component: () => import('@/views/dashboard/Dashboard.vue')
            },
            {
                path: '/transactions/deposit',
                name: 'transactions.deposit',
                meta: { requiresAuth: true, role: 'Customer' },
                component: () => import('@/views/transactions/DepositCreate.vue')
            },
            {
                path: '/transactions/withdraw',
                name: 'transactions.withdraw',
                meta: { requiresAuth: true, role: 'Customer' },
                component: () => import('@/views/transactions/WithdrawCreate.vue')
            },
            {
                path: '/transactions/transfer',
                name: 'transactions.transfer',
                meta: { requiresAuth: true, role: 'Customer' },
                component: () => import('@/views/transactions/TransferCreate.vue')
            },
            {
                path: '/transactions/',
                name: 'transactions.index',
                meta: { requiresAuth: true, role: 'Customer' },
                component: () => import('@/views/transactions/Transactions.vue')
            },
            {
                path: '/reports/transaction',
                name: 'reports.transaction',
                meta: { requiresAuth: true, role: 'Admin' },
                component: () => import('@/views/reports/TransactionReport.vue')
            },
            {
                path: '/accounts',
                name: 'accounts.index',
                meta: { requiresAuth: true, role: 'Admin' },
                component: () => import('@/views/accounts/Accounts.vue')
            },
            {
                path: '/accounts/create',
                name: 'accounts.create',
                meta: { requiresAuth: true, role: 'Admin' },
                component: () => import('@/views/accounts/AccountsCreate.vue')
            },
            {
                path: '/announcements',
                name: 'announcements.index',
                component: () => import('@/views/announcements/Announcements.vue')
            },
            {
                path: '/settings/system',
                name: 'settings.system',
                meta: { requiresAuth: true, role: 'Admin' },
                component: () => import('@/views/settings/SettingsSystem.vue')
            },
            {
                path: '/uikit/formlayout',
                name: 'formlayout',
                component: () => import('@/views/uikit/FormLayout.vue')
            },
            {
                path: '/uikit/input',
                name: 'input',
                component: () => import('@/views/uikit/Input.vue')
            },
            {
                path: '/uikit/floatlabel',
                name: 'floatlabel',
                component: () => import('@/views/uikit/FloatLabel.vue')
            },
            {
                path: '/uikit/invalidstate',
                name: 'invalidstate',
                component: () => import('@/views/uikit/InvalidState.vue')
            },
            {
                path: '/uikit/button',
                name: 'button',
                component: () => import('@/views/uikit/Button.vue')
            },
            {
                path: '/uikit/table',
                name: 'table',
                component: () => import('@/views/uikit/Table.vue')
            },
            {
                path: '/uikit/list',
                name: 'list',
                component: () => import('@/views/uikit/List.vue')
            },
            {
                path: '/uikit/tree',
                name: 'tree',
                component: () => import('@/views/uikit/Tree.vue')
            },
            {
                path: '/uikit/panel',
                name: 'panel',
                component: () => import('@/views/uikit/Panels.vue')
            },

            {
                path: '/uikit/overlay',
                name: 'overlay',
                component: () => import('@/views/uikit/Overlay.vue')
            },
            {
                path: '/uikit/media',
                name: 'media',
                component: () => import('@/views/uikit/Media.vue')
            },
            {
                path: '/uikit/menu',
                component: () => import('@/views/uikit/Menu.vue'),
                children: [
                    {
                        path: '/uikit/menu',
                        component: () => import('@/views/uikit/menu/PersonalDemo.vue')
                    },
                    {
                        path: '/uikit/menu/seat',
                        component: () => import('@/views/uikit/menu/SeatDemo.vue')
                    },
                    {
                        path: '/uikit/menu/payment',
                        component: () => import('@/views/uikit/menu/PaymentDemo.vue')
                    },
                    {
                        path: '/uikit/menu/confirmation',
                        component: () => import('@/views/uikit/menu/ConfirmationDemo.vue')
                    }
                ]
            },
            {
                path: '/uikit/message',
                name: 'message',
                component: () => import('@/views/uikit/Messages.vue')
            },
            {
                path: '/uikit/file',
                name: 'file',
                component: () => import('@/views/uikit/File.vue')
            },
            {
                path: '/uikit/charts',
                name: 'charts',
                component: () => import('@/views/uikit/Chart.vue')
            },
            {
                path: '/uikit/misc',
                name: 'misc',
                component: () => import('@/views/uikit/Misc.vue')
            },
            {
                path: '/blocks',
                name: 'blocks',
                component: () => import('@/views/utilities/Blocks.vue')
            },
            {
                path: '/utilities/icons',
                name: 'icons',
                component: () => import('@/views/utilities/Icons.vue')
            },
            {
                path: '/pages/timeline',
                name: 'timeline',
                component: () => import('@/views/pages/Timeline.vue')
            },
            {
                path: '/pages/empty',
                name: 'empty',
                component: () => import('@/views/pages/Empty.vue')
            },
            {
                path: '/pages/crud',
                name: 'crud',
                component: () => import('@/views/pages/Crud.vue')
            },
            {
                path: '/documentation',
                name: 'documentation',
                component: () => import('@/views/utilities/Documentation.vue')
            }
        ]
    },
    {
        path: '/landing',
        name: 'landing',
        component: () => import('@/views/pages/Landing.vue')
    },
    {
        path: '/pages/notfound',
        name: 'notfound',
        component: () => import('@/views/pages/NotFound.vue')
    },

    // Auth
    {
        path: '/auth/login',
        name: 'auth.login',
        meta: { requiresAuth: false },
        component: () => import('@/views/auth/Login.vue')
    },

    {
        path: '/auth/access',
        name: 'auth.access-denied',
        component: () => import('@/views/auth/AccessDenied.vue')
    },

    // {
    //     path: '/auth/login',
    //     name: 'login',
    //     component: () => import('@/views/pages/auth/Login.vue')
    // },
    // {
    //     path: '/auth/access',
    //     name: 'accessDenied',
    //     component: () => import('@/views/pages/auth/Access.vue')
    // },
    {
        path: '/auth/error',
        name: 'error',
        component: () => import('@/views/pages/auth/Error.vue')
    }
];
