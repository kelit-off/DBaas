import { NavFooter } from '@/components/nav-footer';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link } from '@inertiajs/react';
import AppLogo from './app-logo';
import { type NavItem } from '@/types';
import { NavMain } from './nav-main';

interface Props {
    mainNav?: NavItem[] | null;
    footerNav?: React.ReactNode;
}

export function AppSidebar({ mainNav = null, footerNav = null }: Props) {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            {mainNav && (
                <SidebarContent>
                    <NavMain items={mainNav} />
                </SidebarContent>
            )}

            {footerNav && (
                <SidebarFooter>
                    {footerNav}
                </SidebarFooter>
            )}
        </Sidebar>
    );
}
