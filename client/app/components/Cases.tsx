import { ICases } from "@/types/cases";
import CaseCard from "./CaseCard";

interface CasesProps {
    cases: ICases[]
}

const Cases: React.FC<CasesProps> = ({ cases }) => {
    return (
        <div className="flex flex-wrap gap-4">
            {cases.map((cases) => (
                <CaseCard key={cases.id} cases={cases} />
            ))}
        </div>
    );
};

export default Cases;