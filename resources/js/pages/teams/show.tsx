import { AppSidebar } from "@/components/app-sidebar";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import AppLayout from "@/layouts/app-layout";
import { NavItem } from "@/types";
import { Head, Link, usePage } from "@inertiajs/react";

export default function TeamShowPage() {
    const { slug, projects } = usePage().props;
    console.log(projects);

    const mainNav: NavItem[] = [
        {
            title: "Projets",
            href: "/dashboard/org/" + slug,
        },
        {
            title: "Member",
            href: "/dashboard/org/" + slug + "/member",
        },
        {
            title: "Paramètres de l'organisation",
            href: "/dashboard/org/" + slug + "/settings",
        }
    ]

    return (
        <AppLayout sidebar={<AppSidebar mainNav={mainNav} />}>
            <Head title="Vos projets" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4 md:px-96">
                <h1 className="text-xl">Vos projets</h1>
                <div className='flex flex-row justify-between'>
                    {/* Petite bar de recherche et bouton pour crée nouvelle orga */}
                    <div className="flex items-center space-x-2">
                        <input
                            type="text"
                            placeholder="Rechercher une organisation..."
                            className="px-4 py-2 border border-sidebar-border/70 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                    <div>
                        <Link href={"/dashboard/new/" + slug} prefetch>
                            <Button>
                                Créer un nouveau projet
                            </Button>
                        </Link>
                    </div>
                </div>
                <div>
                    {/* Liste Card des projets */}
                    {projects.map((project: any) => (
                        <Link href={"/dashboard/project/" + project.slug} key={project.slug}>
                            <Card key={project.slug} className="!gap-0 mb-4 p-4 md:min-w-68 md:max-w-68 cursor-pointer hover:bg-muted/50 transition">
                                <h3 className="text-lg font-semibold mb-0">{project.name}</h3>
                                <p>{project.region}</p>
                                {project.compute_instances?.map((instance) => (
                                    <Badge>{instance.compute_plan.name}</Badge>
                                ))}
                                {/* idée indique le type de serveur et sa localité */}
                            </Card>
                        </Link>
                    ))}
                </div>
            </div>
        </AppLayout>
    )
}
