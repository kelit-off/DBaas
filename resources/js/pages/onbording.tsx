import { use, useState } from "react";
import AppLayout from "@/layouts/app-layout";
import { Head } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import axios from "axios";

export default function Onboarding() {
    const [step, setStep] = useState(1);
    const [teamName, setTeamName] = useState("");
    const [team, setTeam] = useState(null);
    const [projectName, setProjectName] = useState("");

    const handleSubmitTeam = async (e) => {
        e.preventDefault();
        console.log("Team Created:", { teamName });

        const response = await axios.post('/teams', { name: teamName });

        if (response.status === 201) {
            setTeam(response.data.team);
            setStep(2);
        }
    };

    const handleSubmitProject = async (e) => {
        e.preventDefault();

        if (!team) return; // sécurité

        const response = await axios.post('/projects', {
            name: projectName,
            team_id: team.id,
        });

        if (response.status === 201) {
            console.log("Project created:", response.data.project);
            
            window.location.href = "/dashboard";
        }
    };


    return (
        <>
            {step === 1 && (
                <AppLayout>
                    <Head title="Créer sa team" />

                    <div className="max-w-xl mx-auto p-6 space-y-6">
                        <h1 className="text-2xl font-bold">Créer votre team DBaaS</h1>
                        <p className="text-muted-200">
                            Entrez le nom de votre équipe pour commencer à gérer vos bases de données.
                        </p>

                        <form onSubmit={handleSubmitTeam} className="space-y-4">
                            <div>
                                <Label className="font-semibold">Nom de la team</Label>
                                <Input
                                    type="text"
                                    value={teamName}
                                    onChange={(e) => setTeamName(e.target.value)}
                                    className="w-full border rounded p-2 mt-1"
                                    placeholder="Ex: Team DBaaS"
                                    required
                                />
                            </div>

                            <Button
                                type="submit"
                                className="px-4 py-2"
                            >
                                Créer la team
                            </Button>
                        </form>
                    </div>
                </AppLayout>
            )}
            {step === 2 && team && (
                <AppLayout>
                    <Head title="Créer un projet" />

                    <div className="max-w-xl mx-auto p-6 space-y-6">
                        <h1 className="text-2xl font-bold">Créer votre projet</h1>
                        <p className="text-muted-200">
                            Entrez le nom du projet pour commencer à gérer vos bases de données.
                        </p>

                        <form onSubmit={handleSubmitProject} className="space-y-4">
                            <div>
                                <Label className="font-semibold">Nom du projet</Label>
                                <Input
                                    type="text"
                                    value={projectName}
                                    onChange={(e) => setProjectName(e.target.value)}
                                    className="w-full border rounded p-2 mt-1"
                                    placeholder="Ex: My App Project"
                                    required
                                />
                            </div>

                            <Button type="submit" className="px-4 py-2">
                                Créer le projet
                            </Button>
                        </form>
                    </div>
                </AppLayout>
            )}

        </>
    );
}
