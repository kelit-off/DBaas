import { AppContent } from '@/components/app-content';
import { AppShell } from '@/components/app-shell';
import { AppSidebarHeader } from '@/components/app-sidebar-header';
import { type BreadcrumbItem } from '@/types';
import { type PropsWithChildren, ReactNode } from 'react';

interface Props {
  breadcrumbs?: BreadcrumbItem[];
  sidebar?: ReactNode;
}

export default function AppSidebarLayout({
  children,
  breadcrumbs = [],
  sidebar = null,
}: PropsWithChildren<Props>) {
  return (
    <AppShell variant="sidebar">
      {/* Sidebar dynamique */}
      {sidebar && sidebar}

      <AppContent variant="sidebar" className="overflow-x-hidden">
        <AppSidebarHeader breadcrumbs={breadcrumbs} />
        {children}
      </AppContent>
    </AppShell>
  );
}
