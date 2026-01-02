import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface AppLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
    sidebar?: ReactNode;
}

export default ({ children, breadcrumbs, sidebar = null, ...props }: AppLayoutProps) => (
    <AppLayoutTemplate breadcrumbs={breadcrumbs} sidebar={sidebar} {...props}>
        {children}
    </AppLayoutTemplate>
);
