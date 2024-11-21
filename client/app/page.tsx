import { getAllTodos } from "@/api";
import AddCase from "./components/AddCase";
import Cases from "./components/Cases";

export default async function Home() {

  const cases = await getAllTodos();
//console.log(tasks)

  return (
    <main className="max-w-4xl mx-auto mt-4 ">
      <div className="text-center my-5 flex flex-col gap-8">
        <h1 className="text-2xl font-bold">Todo List App</h1>
        <AddCase />
      </div>

      <Cases cases={cases} />
    </main>
  );
}
