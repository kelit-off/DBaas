import AppLayout from "@/layouts/app-layout";
import { Head, usePage } from "@inertiajs/react";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import MetricCard from "@/components/MetricCard";
import { NavItem } from "@/types";
import { AppSidebar } from "@/components/app-sidebar";

function Nav(slug: string): NavItem[] {
    return [
        {
            title: "Project Overview",
            href: "/dashboard/project/" + slug,
        },
        {
            title: "Table Editor",
            href: "/dashboard/project/" + slug + "/tables", // Par contre cela redirige vers une page mais cette page le redirigera vers "/dashboard/projects/" + slug + "/tables/{id_table}"
        },
        {
            title: "Sql Editor",
            href: "/dashboard/project/" + slug + "/sql",
        },
        {
            title: "Separator",
        },
        {
            title: "Paramètres du projet",
            href: "/dashboard/project/" + slug + "/settings/general",
        }
    ];
}

export default function ProjectDashboard() {
    const { project, slug } = usePage().props as any;
    console.log("Project data:", project);
    return (
        <AppLayout sidebar={<AppSidebar mainNav={Nav(slug)} />}>
            <Head title={project.name} />

            <div className="px-8 py-6 space-y-8">

                {/* HEADER */}
                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <h1 className="text-2xl font-semibold">
                            {project.name}
                        </h1>

                        {project.computer_instances?.map((instance) => (
                            <Badge key={instance.id} variant="secondary">
                                {instance.name} · {instance.computer_plan.code.toUpperCase()}
                            </Badge>
                        ))}
                    </div>

                    <div className="flex items-center gap-6 text-sm text-neutral-400">
                        <span>
                            Databases{" "}
                            <strong className="text-white">
                                {project?.databases?.length ?? 0}
                            </strong>
                        </span>

                        <span>
                            Instances{" "}
                            <strong className="text-white">
                                {project.computer_instances.length}
                            </strong>
                        </span>

                        <Badge className="bg-emerald-600 text-white">
                            Healthy
                        </Badge>
                    </div>
                </div>

                {/* METRICS */}
                <div className="grid grid-cols-4 gap-6">
                    <MetricCard
                        title="Queries"
                        subtitle="Last 24h"
                        value="12.4k"
                    />

                    <MetricCard
                        title="Connections"
                        subtitle="Active"
                        value="18"
                    />

                    <MetricCard
                        title="Disk Usage"
                        subtitle="GB used"
                        value="1.2"
                    />

                    <MetricCard
                        title="CPU Load"
                        subtitle="Primary"
                        value="23%"
                    />
                </div>

                {/* COMPUTE INSTANCES */}
                <Card>
                    <CardHeader>
                        <CardTitle>Compute Instances</CardTitle>
                    </CardHeader>

                    <CardContent className="space-y-4">
                        {project.computer_instances.map((instance) => (
                            <div
                                key={instance.id}
                                className="flex items-center justify-between rounded-lg border border-neutral-800 px-4 py-3"
                            >
                                <div>
                                    <div className="font-medium">
                                        {instance.name}
                                    </div>
                                    <div className="text-sm text-neutral-400">
                                        {instance.computer_plan.cpu_cores} vCPU ·{" "}
                                        {instance.computer_plan.memory_mb} MB RAM
                                    </div>
                                </div>

                                <div className="flex items-center gap-4">
                                    <Badge variant="secondary">
                                        {instance.computer_plan.name}
                                    </Badge>

                                    <Badge
                                        className={
                                            instance.status === "running"
                                                ? "bg-emerald-600 text-white"
                                                : "bg-yellow-600 text-white"
                                        }
                                    >
                                        {instance.status}
                                    </Badge>
                                </div>
                            </div>
                        ))}
                    </CardContent>
                </Card>

                {/* DATABASE HEALTH */}
                <Card>
                    <CardHeader>
                        <CardTitle>Database Health</CardTitle>
                    </CardHeader>

                    <CardContent className="text-neutral-400 space-y-2">
                        <div className="flex justify-between">
                            <span>Replication lag</span>
                            <span className="text-white">0 ms</span>
                        </div>

                        <div className="flex justify-between">
                            <span>Backups</span>
                            <span className="text-white">Enabled</span>
                        </div>

                        <div className="flex justify-between">
                            <span>Point-in-time recovery</span>
                            <span className="text-white">Enabled</span>
                        </div>
                    </CardContent>
                </Card>

                {/* SLOW QUERIES */}
                <Card>
                    <CardHeader>
                        <CardTitle>Slow Queries</CardTitle>
                    </CardHeader>

                    <CardContent>
                        <div className="flex justify-between text-sm">
                            <span className="font-mono">
                                SELECT name FROM pg_timezone_names
                            </span>
                            <span className="text-neutral-400">
                                0.15s · 61 calls
                            </span>
                        </div>
                    </CardContent>
                </Card>

            </div>
        </AppLayout>
    );
}
