import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Organisation',
        // href: dashboard().url,
    },
];

export default function Dashboard() {
    const { teams } = usePage().props;
    console.log(teams);
    return (
        <AppLayout breadcrumbs={breadcrumbs} sidebar={null}>
            <Head title="Organisation" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4 md:px-96">
                <h1 className='text-xl'>Vos organisations</h1>
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
                        <Link href="/dashboard/new" prefetch>
                            <Button>
                                Créer une nouvelle organisation
                            </Button>
                        </Link>
                    </div>
                </div>
                <div className='flex flex-wrap gap-3'>
                    {/* Liste Card des organisations */}
                    {teams.map((team: any) => (
                        <Link href={"/dashboard/org/"+team.slug}>
                            <Card key={team.id} className="mb-4 p-4 md:min-w-68 md:max-w-68 cursor-pointer hover:bg-muted/50 transition">
                                <h3 className="text-lg font-semibold">{team.name}</h3>
                                <div className='flex flex-row items-center gap-2 text-muted-200 text-sm'>
                                    <span>{team.pricing_plan.name.charAt(0).toUpperCase() + team.pricing_plan.name.slice(1)} Plan</span>
                                    <p className="">
                                        {team.projects_count} projet{team.projects_count > 1 ? 's' : ''}
                                    </p>
                                </div>
                            </Card>
                        </Link>
                    ))}
                </div>
            </div>
        </AppLayout>
    );
}
