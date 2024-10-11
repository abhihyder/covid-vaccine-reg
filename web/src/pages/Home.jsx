import { Link } from "react-router-dom";
import Search from "../components/Search";

export default function Home() {
  return (
    <>
      <section className="flex flex-col items-center text-center mt-16">
        <h1 className="text-5xl font-bold text-gray-900 mb-4">
          Register for Your <span className="text-blue-600">COVID-19</span>{" "}
          Vaccination.
        </h1>
        <p className="text-gray-500 text-lg max-w-2xl">
          Stay Safe, Get Vaccinated – Secure Your Spot at the Nearest Vaccine
          Center Today!
        </p>
        <div className="mt-8 space-x-4">
          <Link
            to="/register"
            className="bg-black text-white py-3 px-6 rounded-lg"
          >
            Register
          </Link>
        </div>
      </section>

      <Search />
    </>
  );
}
