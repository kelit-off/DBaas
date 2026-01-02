import { AppSidebar } from "@/components/app-sidebar";
import AppLayout from "@/layouts/app-layout";
import { NavItem, SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";

export default function Members() {
    const { team, auth, slug } = usePage<SharedData>().props as any;

    const mainNav: NavItem[] = [
        {
            title: "Projets",
            href: "/dashboard/org/" + slug,
            isActive: false,
        },
        {
            title: "Member",
            href: "/dashboard/org/" + slug + "/member",
            isActive: true
        },
        {
            title: "Paramètres de l'organisation",
            href: "/dashboard/org/" + slug + "/settings",
        }
    ]

    const currentUser = team.users.find(
        (u: any) => u.id === auth.user.id
    );
    const current_user_role = currentUser?.pivot.role;

    return (
        <AppLayout sidebar={<AppSidebar mainNav={mainNav} />}>
            <Head title="Team" />

            <div className="max-w-4xl w-full mx-auto py-10">
                {/* Header */}
                <div className="flex items-center justify-between mb-6">
                    <h1 className="text-xl font-semibold text-white">
                        Team
                    </h1>

                    <div className="flex gap-2">
                        <button className="btn-secondary">Docs</button>
                        <button className="btn-primary">Invite member</button>
                    </div>
                </div>

                {/* Card */}
                <div className="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
                    <table className="w-full text-sm">
                        <thead className="border-b border-gray-800 text-gray-400">
                            <tr>
                                <th className="text-left px-6 py-3 font-medium">
                                    User
                                </th>
                                <th className="text-center px-6 py-3 font-medium">
                                    Enabled MFA
                                </th>
                                <th className="text-left px-6 py-3 font-medium">
                                    Role
                                </th>
                                <th className="px-6 py-3" />
                            </tr>
                        </thead>

                        <tbody>
                            {team.users.map((member: any) => {
                                const canEditRole =
                                    (current_user_role === "owner" || current_user_role === "admin") &&
                                    !member.is_you &&
                                    member.role !== "owner";

                                const canLeaveTeam =
                                    member.is_you &&
                                    current_user_role !== "owner";

                                return (
                                    <tr
                                        key={member.id}
                                        className="border-b border-gray-800 last:border-0"
                                    >
                                        <td className="px-6 py-4">
                                            {member.email}
                                        </td>

                                        <td className="px-6 py-4 text-center">
                                            {member.two_factor_confirmed_at ? "✓" : "✕"}
                                        </td>

                                        <td className="px-6 py-4 text-white capitalize">
                                            {member.pivot.role}
                                        </td>

                                        <td className="px-6 py-4 text-right space-x-3">
                                            {canEditRole && (
                                                <button className="text-sm text-blue-400 hover:text-blue-300">
                                                    Modifier
                                                </button>
                                            )}

                                            {canLeaveTeam && (
                                                <button className="text-sm text-red-400 hover:text-red-300">
                                                    Quitter l’équipe
                                                </button>
                                            )}
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>

                    <div className="px-6 py-3 text-sm text-gray-400">
                        {team.users.length} user(s)
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
