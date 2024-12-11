import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import './styles/main.scss';
import App from './App';
// import QuemSomos from './pages/QuemSomos';
// import Eventos from './pages/Eventos';
import MathTrade from './pages/mathtrade/MathTrade';
// import MathTradeRegrasGerais from './pages/MathTradeRegrasGerais';
// import MathTradeEdicaoFevereiro from './pages/MathTradeEdicaoFevereiro';

ReactDOM.createRoot(document.getElementById('root')!).render(
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<App />} />
      {/* <Route path="/quem-somos" element={<QuemSomos />} /> */}
      {/* <Route path="/eventos" element={<Eventos />} /> */}
      <Route path="/mathtrade-bh/" element={<MathTrade />} />
      {/* <Route path="/mathtrade-bh/regras-gerais" element={<MathTradeRegrasGerais />} /> */}
      {/* <Route path="/mathtrade-bh/edicao-fevereiro" element={<MathTradeEdicaoFevereiro />} /> */}
    </Routes>
  </BrowserRouter>
);
