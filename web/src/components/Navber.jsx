import { Link } from "react-router-dom";

export default () => {
  return (
    <nav className="flex justify-between items-center py-6 px-10">
      <div className="flex items-center space-x-2">
        <div className="text-2xl font-bold text-blue-600">
          {" "}
          <Link to="/">COVID-19</Link>
        </div>
      </div>
      <div className="space-x-4">
      </div>
    </nav>
  );
};
