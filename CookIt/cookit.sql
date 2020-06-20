-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 14-Jul-2018 às 11:13
-- Versão do servidor: 10.1.23-MariaDB-9+deb9u1
-- PHP Version: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cookit`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comments`
--

CREATE TABLE `comments` (
  `email` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `post_date` date NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `favorites`
--

INSERT INTO `favorites` (`user_id`, `recipe_id`) VALUES
(1, 24),
(1, 22),
(1, 23),
(1, 26),
(1, 30),
(1, 31),
(1, 36);

-- --------------------------------------------------------

--
-- Estrutura da tabela `questions`
--

CREATE TABLE `questions` (
  `email` varchar(100) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `question` text NOT NULL,
  `post_date` date NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recipes`
--

CREATE TABLE `recipes` (
  `title` varchar(100) NOT NULL,
  `dificulty` varchar(50) NOT NULL,
  `time_drt` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `robot` varchar(50) NOT NULL,
  `ingredients` text NOT NULL,
  `img_path` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `public` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lst_chg_date` datetime NOT NULL,
  `valid` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `recipes`
--

INSERT INTO `recipes` (`title`, `dificulty`, `time_drt`, `category`, `robot`, `ingredients`, `img_path`, `public`, `user_id`, `lst_chg_date`, `valid`, `id`) VALUES
('Bolo de maçã', 'easy', 0, 'cakes_cookies', '', '<p align=\"center\">300g de farinha</p><p align=\"center\">1 colher de chá de fermento</p><p align=\"center\">10g de canela</p><p align=\"center\">5g de sal</p><p align=\"center\">250g de açucar amarelo sidul</p><p align=\"center\">50g de passas</p><p align=\"center\">125g de margarina</p><p align=\"center\">4 ovos</p><p align=\"center\">2,5dl de leite</p><p align=\"center\">250g de maçã<br></p>', 'default.jpg', 1, 2, '2018-06-22 20:32:32', 1, 20),
('Aveludado de iogurte e frutos vermelhos', 'easy', 30, 'desserts', '', '<div align=\"center\"><div>2 folhas de gelatina vermelha</div><div>2dl de natas frescas</div><div>3c. de sopa de frutose</div><div>2 iogurtes de aroma a frutos vermelhos</div><div>1 clara de ovo</div>framboesas e groselhas q.b.</div>', 'default.jpg', 1, 2, '2018-06-23 13:47:59', 1, 21),
('Sopa de cogumelos', 'easy', 35, 'soups', '', '<div align=\"center\">300g de batata<br>1 cebola<br>1 dente de alho<br>1/2 alho francês<br>2c. de sopa de manteiga<br>1 lata de cogumelos<br>1/2l de água<br>1 pacote de natas<br>100g de cogumelos-paris<br>sal, pimenta e salsa q.b.</div>', '22.jpg', 1, 2, '2018-07-02 22:29:24', 1, 22),
('Sopa de legumes', 'easy', 35, 'soups', '', '<div align=\"center\">400g de batata-doce</div><div align=\"center\">1 cebola</div><div align=\"center\">1/2 alho francês</div><div align=\"center\">1/2 brócolo</div><div align=\"center\">1/2 couve-flor</div><div align=\"center\">1/2 couve coração-de-boi</div><div align=\"center\">1,2L de água</div><div align=\"center\">2 cenouras</div><div align=\"center\">100g de feijão verde</div><div align=\"center\">4 talos de rama de aipo</div><div align=\"center\">1c. de manteiga</div><div align=\"center\">azeite, sal e tomilho q.b.<br></div><p><br></p>', '23.jpg', 1, 2, '2018-07-02 22:31:21', 1, 23),
('Peru com citrinos', 'easy', 30, 'meat_dishes', '', '<p style=\"text-align: center;\">2 laranjas</p><p style=\"text-align: center;\">2 limões</p><p style=\"text-align: center;\">4 bifes de peru</p><p style=\"text-align: center;\">2 c. de sopa de ervas aromáticas</p><p style=\"text-align: center;\">60 g de manteiga-de-soja</p><p style=\"text-align: center;\">4 cunquates</p><p style=\"text-align: center;\">tomilho, sal, pimenta rosa e limão q. b.</p>', '24.jpg', 1, 2, '2018-07-02 22:24:47', 1, 24),
('Espetada de peru com cuscuz e alface', 'easy', 25, 'meat_dishes', '', '<p style=\"text-align: center;\">300 g de cuscuz&nbsp;</p><p style=\"text-align: center;\">4 peitos de peru</p><p style=\"text-align: center;\">1 limão</p><p style=\"text-align: center;\">1 alho-francês</p><p style=\"text-align: center;\">1 cenoura</p><p style=\"text-align: center;\">&nbsp;1 romã</p><p style=\"text-align: center;\">1 embalagem de misto de alface</p><p style=\"text-align: center;\">sal, pimenta em grão, azeite e vinagre balsâmico q. b.</p>', 'default.jpg', 1, 2, '2018-06-24 15:37:53', 1, 25),
('Massa com salmão', 'easy', 30, 'fish_seafood_dishes', '', '<p style=\"text-align: center;\">300 g de tagliatelle verde</p><p style=\"text-align: center;\">500 g de postas de salmão</p><p style=\"text-align: center;\">1 cebola</p><p style=\"text-align: center;\">1 dente de alho</p><p style=\"text-align: center;\">0,5 dl de azeite</p><p style=\"text-align: center;\">100 g de tomate-cereja</p><p style=\"text-align: center;\">1 c. de sopa de azeitonas pretas</p><p style=\"text-align: center;\">1 c. de sopa de alcaparras</p><p style=\"text-align: center;\">sal, azeite, pimenta em grão e manjericão q. b.</p>', '26.jpg', 1, 2, '2018-07-02 22:16:36', 1, 26),
('Esparguete com camarão', 'easy', 30, 'fish_seafood_dishes', '', '<p style=\"text-align: center;\">1 cebola</p><p style=\"text-align: center;\">2 dentes de alho </p><p style=\"text-align: center;\">50 ml de azeite</p><p style=\"text-align: center;\">800 g de miolo de camarão</p><p style=\"text-align: center;\">2 c. de sopa de polpa de tomate </p><p style=\"text-align: center;\">1 dl de vinho branco</p><p style=\"text-align: center;\">200 g de feijão verde redondo</p><p style=\"text-align: center;\">300 g de esparguete</p><p style=\"text-align: center;\">sal, pimenta, óleo e salsa q. b.</p>', '27.jpg', 1, 2, '2018-07-02 22:14:35', 1, 27),
('Bife de atum grelhado', 'easy', 0, 'fish_seafood_dishes', '', '<p style=\"text-align: center; line-height: 1;\">800 g de bifes de atum</p><p style=\"text-align: center; line-height: 1;\">1 limão (sumo)</p><p style=\"text-align: center; line-height: 1;\">1 raminho de salsa</p><p style=\"text-align: center; line-height: 1;\">1 raminho de coentros</p><p style=\"text-align: center; line-height: 1;\">1 raminho de tomilho</p><p style=\"text-align: center; line-height: 1;\">1 dl de azeite</p><p style=\"text-align: center; line-height: 1;\">200 g de cenoura</p><p style=\"text-align: center; line-height: 1;\">400 g de chuchu</p><p style=\"text-align: center; line-height: 1;\">200 g de brócolos</p><p style=\"text-align: center; line-height: 1;\">1 folha de louro</p><p style=\"text-align: center; line-height: 1;\">sal, pimenta, ervas frescas e azeite q.b.</p>', '28.jpg', 1, 1, '2018-07-03 20:07:08', 1, 28),
('Tostas de peru gratinadas', 'easy', 0, 'food_entrances_salads', '', '<p style=\"text-align: center; line-height: 1;\">4 carcaças</p><p style=\"text-align: center; line-height: 1;\">2 dentes de alho</p><p style=\"text-align: center; line-height: 1;\">4 c. (de sopa) de azeite</p><p style=\"text-align: center; line-height: 1;\">2 c. de sopa de maionese light</p><p style=\"text-align: center; line-height: 1;\">2 tomates maduros</p><p style=\"text-align: center; line-height: 1;\">150 g de bife de peru cozido</p><p style=\"text-align: center; line-height: 1;\">sal, pimenta, raspa de limão, alface e tomate-cereja q.b.</p>', '29.jpg', 1, 1, '2018-07-03 23:30:57', 1, 29),
('Bolo de cenoura com chocolate', 'easy', 13, 'cakes_cookies', 'Bimby TM31', '<p style=\"text-align: center; line-height: 1;\"><b>Bolo:</b></p><p style=\"text-align: center; line-height: 1;\">250 g cenoura</p><p style=\"text-align: center; line-height: 1;\">4 ovos</p><p style=\"text-align: center; line-height: 1;\">110 g óleo</p><p style=\"text-align: center; line-height: 1;\">320 g açúcar</p><p style=\"text-align: center; line-height: 1;\">220 g farinha</p><p style=\"text-align: center; line-height: 1;\">1 c. sopa de fermento p/ bolos</p><p style=\"text-align: center; line-height: 1;\"><b>Cobertura:</b></p><p style=\"text-align: center; line-height: 1;\">40 g margarina</p><p style=\"text-align: center; line-height: 1;\">70 g açúcar</p><p style=\"text-align: center; line-height: 1;\">40 g chocolate em pó</p><p style=\"text-align: center; line-height: 1;\">40 g leite</p>', '30.jpg', 1, 1, '2018-07-04 08:58:49', 1, 30),
('Quiche de atum', 'easy', 45, 'fish_seafood_dishes', 'Bimby TM5', '<p style=\"text-align: center; line-height: 1;\">250 g farinha</p><p style=\"text-align: center; line-height: 1;\">100 g manteiga</p><p style=\"text-align: center; line-height: 1;\">70 g água</p><p style=\"text-align: center; line-height: 1;\">1 colher de chá sal</p><p style=\"text-align: center; line-height: 1;\">150 g cebolas brancas</p><p style=\"text-align: center; line-height: 1;\">10 g salsa</p><p style=\"text-align: center; line-height: 1;\">2 dente alho</p><p style=\"text-align: center; line-height: 1;\">80 g tomate fresco</p><p style=\"text-align: center; line-height: 1;\">150 g pimento vermelho</p><p style=\"text-align: center; line-height: 1;\">360 g atum em lata</p><p style=\"text-align: center; line-height: 1;\">q.b. sal</p><p style=\"text-align: center; line-height: 1;\">q.b. pimenta</p><p style=\"text-align: center; line-height: 1;\">2 unidade ovos médios</p><p style=\"text-align: center; line-height: 1;\">120 g iogurte natural</p><p style=\"text-align: center; line-height: 1;\">150 g queijo mozarela</p><p style=\"text-align: center; line-height: 1;\">125 g Queijo mozarela fresco</p><p style=\"text-align: center; line-height: 1;\">1 unidade ovo de codorniz</p><p style=\"text-align: center; line-height: 1;\">q.b. pimento vermelho</p>', '31.jpg', 1, 1, '2018-07-04 09:08:51', 1, 31),
('Salada russa', 'easy', 0, 'fish_seafood_dishes', 'Bimby TM31', '<p style=\"text-align: center; line-height: 1;\"><b>Salada Russa:</b></p><p style=\"text-align: center; line-height: 1;\">4 Latas de Atum</p><p style=\"text-align: center; line-height: 1;\">4 ovos</p><p style=\"text-align: center; line-height: 1;\">200g batata</p><p style=\"text-align: center; line-height: 1;\">120g cenoura</p><p style=\"text-align: center; line-height: 1;\">300g couve-flor</p><p style=\"text-align: center; line-height: 1;\">200g brócolos</p><p style=\"text-align: center; line-height: 1;\">250g ervilhas</p><p style=\"text-align: center; line-height: 1;\">Sal q.b.</p><p style=\"text-align: center; line-height: 1;\">700g água</p><p style=\"text-align: center; line-height: 1;\"><b>Maionese:</b></p><p style=\"text-align: center; line-height: 1;\">1 receita de maionese feita na Bimby (livro base) ou outra de sua preferência</p>', '32.jpg', 1, 1, '2018-07-04 09:18:17', 1, 32),
('Tarte de alfarroba', 'easy', 5, 'cakes_cookies', 'Bimby TM5', '<p style=\"text-align: center; line-height: 1;\">6 ovos</p><p style=\"text-align: center; line-height: 1;\">250 grama açúcar mascavado</p><p style=\"text-align: center; line-height: 1;\">1 colher de sopa farinha trigo</p><p style=\"text-align: center; line-height: 1;\">2 colher de sopa farinha de alfarroba</p><p style=\"text-align: center; line-height: 1;\">2 colher de sopa manteiga amolecida</p><p style=\"text-align: center; line-height: 1;\">2 colher de sopa mel</p><p style=\"text-align: center; line-height: 1;\">100 grama amêndoa ralada</p>', '33.jpg', 1, 1, '2018-07-04 09:25:09', 1, 33),
('Queques de cenoura com pepitas de chocolate', 'easy', 0, 'cakes_cookies', 'Bimby TM5', '<p style=\"text-align: center; line-height: 1;\">5 ovos</p><p style=\"text-align: center; line-height: 1;\">300g Cenoura (crua e sem casca)</p><p style=\"text-align: center; line-height: 1;\">200g açúcar</p><p style=\"text-align: center; line-height: 1;\">100g Óleo (usei girassol)</p><p style=\"text-align: center; line-height: 1;\">300g farinha Branca de Neve</p><p style=\"text-align: center; line-height: 1;\">1 c. chá de fermento em pó</p><p style=\"text-align: center; line-height: 1;\">1 c. chá de bicarbonato de sódio</p><p style=\"text-align: center; line-height: 1;\">150g Chocolate em barra (usei Pantagruel)</p>', '34.jpg', 1, 1, '2018-07-04 09:30:29', 1, 34),
('Almôndegas', 'medium', 31, 'meat_dishes', 'Bimby TM31', '<p style=\"text-align: center; line-height: 1;\"><b>Almôndegas:</b></p><p style=\"text-align: center; line-height: 1;\">300 g pão duro</p><p style=\"text-align: center; line-height: 1;\">100 g leite</p><p style=\"text-align: center; line-height: 1;\">50 g sobras de pão</p><p style=\"text-align: center; line-height: 1;\">50 g chouriço</p><p style=\"text-align: center; line-height: 1;\">500 g carne picada</p><p style=\"text-align: center; line-height: 1;\">20 g salsa, cortada</p><p style=\"text-align: center; line-height: 1;\">1 ovo</p><p style=\"text-align: center; line-height: 1;\">sal, q.b.</p><p style=\"text-align: center; line-height: 1;\">pimenta, q.b.</p><p style=\"text-align: center; line-height: 1;\">Noz-moscada, q.b.</p><p style=\"text-align: center; line-height: 1;\"><b>Molho:</b></p><p style=\"text-align: center; line-height: 1;\">100 g cebola</p><p style=\"text-align: center; line-height: 1;\">1 dente de alho</p><p style=\"text-align: center; line-height: 1;\">100 g tomate pelado</p><p style=\"text-align: center; line-height: 1;\">50 g azeite</p><p style=\"text-align: center; line-height: 1;\">250 g água</p><p style=\"text-align: center; line-height: 1;\">100 g vinho branco</p><p style=\"text-align: center; line-height: 1;\">sal, q.b.</p><p style=\"text-align: center; line-height: 1;\">pimenta moída, q.b.</p><p style=\"text-align: center; line-height: 1;\">pimenta, q.b.</p><p style=\"text-align: center; line-height: 1;\">Noz-moscada, q.b.</p>', '35.jpg', 1, 1, '2018-07-04 09:35:48', 1, 35),
('Cookies de manteiga de amendoim', 'easy', 2, 'cakes_cookies', 'Bimby TM5', '<p style=\"text-align: center; line-height: 1;\">100 g manteiga, temperatura ambiente</p><p style=\"text-align: center; line-height: 1;\">150 g manteiga de amendoim, temperatura ambiente</p><p style=\"text-align: center; line-height: 1;\">100 g açúcar</p><p style=\"text-align: center; line-height: 1;\">75 g açúcar amarelo</p><p style=\"text-align: center; line-height: 1;\">1 unidade ovo</p><p style=\"text-align: center; line-height: 1;\">170 g farinha</p><p style=\"text-align: center; line-height: 1;\">1 pitada sal grosso</p><p style=\"text-align: center; line-height: 1;\">1/2 colher de chá bicarbonato de sódio</p>', '36.jpg', 1, 1, '2018-07-04 09:39:52', 1, 36);

-- --------------------------------------------------------

--
-- Estrutura da tabela `steps`
--

CREATE TABLE `steps` (
  `step_n` int(11) NOT NULL,
  `value` text NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `steps`
--

INSERT INTO `steps` (`step_n`, `value`, `recipe_id`) VALUES
(1, '<div align=\"center\">Peneire a farinha, junte o fermento, a canela, e o sal. De seguida misture o açucar e as passas. </div><div align=\"center\">Junte a margarina derretida e mexa bem. Bata os ovos até esbranquiçarem e adicione-os ao preparado anterior. Por fim, junte o leite e as maçãs aos cubinhos.</div><div align=\"center\">Coloque o preparado numa forma untada com manteiga e polvilhada de farinha e leve ao forno a 180 graus durante cerca de 35 minutos.</div>', 20),
(1, '<div align=\"center\">Coloque as folhas de gelatina de molho em água fria. Bata as natas e \r\nenvolva-lhes duas colheres, de sopa, da frutose e os iogurtes. Retire \r\nduas colheres de sopa deste preparado e adicione-lhes as folhas de \r\ngelatina escorridas.</div>', 21),
(2, '<p align=\"center\">Derreta, em lume , e junte novamente ao preparado das natas. Levante a \r\nclara em castelo e junte-lhe a restante frutose, batendo mais um pouco.</p>', 21),
(3, '<div align=\"center\">Envolva no preparado anterior e distribua por taças. Coloque-as no frigorífico até à hora de servir. Nessa altura, decore-as com framboesas e groselhas e sirva.</div><div align=\"center\"><br></div><div align=\"center\"><p align=\"center\"><b>Dica:</b><br></p>Misture no creme alguns frutos vermelhos, ligeiramente triturados.</div>', 21),
(1, '<div align=\"center\">Corte as batatas, a cebola, o alho e o alho francês em pedaços e refogue-os em metade da manteiga. Junte a lata dos cogumelos escorridos e verta a água. Tempere com sal e pimenta e deixe cozer.</div>', 22),
(3, '<div align=\"center\">Lamine os cogumelos frescos e core-os na restante manteiga. Retire e sirva-os sobre a sopa. Decore-a com salsa.</div><div align=\"center\"><br></div><div align=\"center\"><div align=\"center\"><b>Dica:</b><br></div><div align=\"center\">Torre alguns pinhoẽs e sirva-os na sopa a decorá-la, juntamente com os cogumelos-paris.<br></div></div>', 22),
(2, '<div align=\"center\">Quando os legumes se encontrarem cozidos, triture-os e passe a sopa por \r\num passador de rede. Junte-lhe as natas e leve novamente ao lume, até \r\nferver.</div><p><br></p>', 22),
(2, '<div align=\"center\">Entretanto, corte as cenouras e o feijão verde em cubos pequenos e o aipo em meias-luas. Leve tudo ao lume com manteiga e deixe saltear. Triture a sopa e junte-lhe os legumes salteados. Distribua pelos pratos e decore com um pouco de tomilho; sirva.<br></div><p><br></p>', 23),
(1, '<div align=\"center\">Descasque as batatas e a cebola e corte-as em pedaços, assim como o alho francês. Refogue tudo em azeite e deixe ganhar cor. Junte o brócolo, a couve-flor e a couve coração-de-boi, cortados em pedaços. tempere com sal, verta a água e deixe cozer.<br></div><p><br></p>', 23),
(3, '<p style=\"text-align: center;\">DICA</p><p style=\"text-align: center;\">Acrescente aos citrinos um quivi oas cubos.</p>', 24),
(2, '<p style=\"text-align: center;\">Tempere a carne com sal e as ervas aromáticas e frite-a na manteiga de soja de ambos os lados.       Sirva os bifes com a fruta e decore com os cunquates às rodelas e pimenta rosa, moída na altura.</p>', 24),
(1, '<p style=\"text-align: center;\">Descasque as laranjas e os limões, corte-os em cubos para uma tigela e junte-lhes um pouco de tomilho picado; reserve.</p><p style=\"text-align: center;\"><br></p>', 24),
(1, '<p style=\"text-align: center;\">Verta os cuscuz para um tabuleiro, tempere-os com um pouco de sal e pimenta moída na altura e, de seguida, cubra-os com o dobro do volume de água a ferver. Tape com película aderente e deixe repousar por oito minutos.</p>', 25),
(2, '<p style=\"text-align: center;\">Arranje a carne, tempere-a com sal, pimenta e o sumo do limão. Grelhe-a de ambos os lados e, de seguida, corte-a em tiras. Coloque-as em palitos de espetada e reserve em local quente. Entretanto, corte o alho-francês e a cenoura em cubos pequenos e salteie-os num pouco de azeite.</p><p style=\"text-align: center;\"><br></p>', 25),
(3, '<p style=\"text-align: center;\">Misture-os aos cuscuz e solte-os com um garfo. Retire os bagos à romã e misture-os com as várias alfaces. Sirva a salada com as espetadas de peru e os cuscuz e regue com um pouco de vinagre balsâmico.</p>', 25),
(3, '<p style=\"text-align: center;\">Deixe cozinhar por cinco a sete minutos, acrescente a massa cozida e as alcaparras. Envolva, transfira para uma tigela e, antes de servir, regue com azeite e polvilhe com pimenta, moída na hora, e manjericão picado.</p>', 26),
(1, '<p style=\"text-align: center;\">Coza a massa  em água temperada com sal, durante sete minutos; escorra-a e reserve-a. Corte o salmão em pedacinhos e tempere-os com um pouco de sal.</p>', 26),
(3, '<p style=\"text-align: center;\">Corte o feijão em pedaços e envolva-os no camarão. Retire o preparado do lume e misture com o esparguete. Sirva decorado com uma folhinha de salsa.</p>', 27),
(2, '<p style=\"text-align: center;\">Escalde o feijão verde, em água abundante temperada com sal e pimenta; escorra-o e reserve-o. Coza o esparguete em água abundante temperada com um fio de óleo e sal; escorra-o.</p>', 27),
(1, '<p style=\"text-align: center;\">Pique a cebola e os alhos e refogue-os no azeite. Acrescente-lhes o miolo de camarão e deixe corar. Junte a polpa de tomate, regue com o vinho e deixe cozinhar mais um pouco.</p>', 27),
(2, '<p style=\"text-align: center;\">Pique a cebola e o alho e refogue-os no azeite, em lume brando. Junte o salmão e deixe alourar. Corte o tomate em pedacinhos e adicione-os ao peixe, assim como as azeitonas.</p>', 26),
(1, '<p style=\"text-align: center; \">Tempere os bifes de atum com o sumo de limão, as ervas picadas e o azeite; deixe tomar sabor durante meia hora. Corte a cenoura em rodelas finas, o chuchu em gomos e os brócolos em raminhos.</p>', 28),
(2, '<p style=\"text-align: center;\">Coza os legumes em água temperada com sal, pimenta e a folha de louro; escorra-os e reserve-os. Grelhe o atum em chapa bem quente. Misture ervas frescas picadas com azeite e regue o peixe. Sirva-o, decorado a gosto, com os legumes grelhados.</p><p style=\"text-align: left;\"><b>Nota:</b></p><p style=\"text-align: left;\">    Frigorífico: 3 dias; Não congelar.</p>', 28),
(1, '<p style=\"text-align: justify;\">Corte os pães ao meio. Triture os alhos, distribua-os pelo pão e regue-os com o azeite. Torre-os de seguida.</p>', 29),
(2, '<p style=\"text-align: justify;\">Retire a pele e as sementes ao tomate, corte-o em cubos pequenos para uma tigela e junte-lhes a carne desfiada e a maionese.</p>', 29),
(3, '<p style=\"text-align: justify; \">Tempere com sal e pimenta, envolva e coloque sobre as tostas. Polvilhe-as com raspa de limão e leve-as a gratinar. Sirva as tostas sobre folhas de alface e decore com tomate-cereja.</p><p style=\"text-align: justify; line-height: 1;\"><b>Nota:</b></p><p style=\"text-align: justify; line-height: 1;\">&nbsp; &nbsp; Frigorífico: 2 dias; Não congelar.<br></p>', 29),
(1, '<p style=\"text-align: justify; \">Pré-aqueça o forno a 180°C. Unte uma forma de coroa com margarina e polvilhe com farinha. Reserve.<br></p>', 30),
(2, '<p style=\"text-align: justify;\">Coloque no copo a cenoura e rale 15 seg/vel 9.<br></p>', 30),
(3, '<p style=\"text-align: justify;\">Adicione os ovos, o óleo e o açúcar e programe 1 min/vel 6.<br></p>', 30),
(4, '<p style=\"text-align: justify; \">Adicione a farinha e o fermento e envolva 15 seg/vel 3.Deite o preparado e leve ao forno cerca de 40 minutos. Retire do forno e espere que o bolo arrefeça.<br></p>', 30),
(1, '<p style=\"text-align: justify;\">Pré-aqueça o forno a 180°C.<br></p>', 31),
(2, '<p style=\"text-align: justify; \">Coloque no copo o queijo e pique 10 seg/vel4.&nbsp;<br></p>', 31),
(3, '<p style=\"text-align: justify;\">Coloque no copo a farinha, a manteiga, água e o sal, misture 15 seg/vel 6. Retire, forre o fundo e a lateral de uma tarteira com 26 cm de diâmetro aproximadamente. Pique com um garfo e reserve.&nbsp;<br></p>', 31),
(4, '<p style=\"text-align: justify; \">No copo coloque a cebola, alho, azeite, o tomate e o pimento vermelho, programe 5 seg/vel5.<br></p>', 31),
(5, '<p style=\"text-align: justify;\">Adicione o atum, refogue 5 min/120°C/ vel 1. Rectifique os temperos. Retire e deite sobre a massa.&nbsp;<br></p>', 31),
(6, '<p style=\"text-align: justify;\">Coloque no copo os ovos, o iogurte e bata 6 seg/vel6. Deite o preparado sobre o atum.&nbsp;<br></p>', 31),
(7, '<p style=\"text-align: justify;\">Polvilhe com o queijo ralado e a mozarela fresca previamente cortada em fatias. No centro da tarteira coloque um ovo de codorniz e várias tiras de pimento vermelho em seu redor.<br></p>', 31),
(8, '<p style=\"text-align: justify;\">Leve ao forno por 35 min a 180°C. Sirva acompanhado de uma salada.<br></p>', 31),
(1, '<p style=\"text-align: justify; \"><b>Maionese:</b></p><p style=\"text-align: justify; \">Se optar por fazer a maionese na Bimby, faça a receita do livro base e guarde no frigorífico.</p>', 32),
(2, '<p style=\"text-align: justify;\"><b>Salada Russa:</b></p><p style=\"text-align: justify;\">Prepare os legumes (corte aos bocados) distribua pelo cesto e varoma e tempere com sal:</p><p style=\"text-align: justify;\">- No cesto: coloque as batatas, as cenouras e os ovos.&nbsp;</p><p style=\"text-align: justify;\">- Na varoma: a couve-flor e os brócolos.&nbsp;</p><p style=\"text-align: justify;\">- No tabuleiro: as ervilhas.</p><p style=\"text-align: justify;\">No copo da bimby adicionar a água, colocar o cesto, montar a varoma e programar 35min/temp.varoma/vel.1.<br></p>', 32),
(3, '<p><b>Empratamento</b></p><p>-&nbsp;Faça uma cama de legumes, depois o atum escorrido e por fim os ovos.</p><p>-&nbsp;Se preferir, também pode envolver o atum e os ovos na maionese e servir tudo misturado.<br><br></p>', 32),
(1, '<p style=\"text-align: justify; \">Forrar um tabuleiro com papel vegetal untado com manteiga.<br></p>', 33),
(2, '<p style=\"text-align: justify; \">Na varoma colocar a manteiga, o açúcar e o mel e bater 2m/37º/vel3 até ficar cremoso.<br></p>', 33),
(3, '<p style=\"text-align: justify; \">Programar 1m/vel 3 e adicionar os ovos pelo bocal um a um.&nbsp;<br></p>', 33),
(4, '<p style=\"text-align: justify; \">Adicionar a amêndoa e mexer 1m/vel 3.<br></p>', 33),
(5, '<p style=\"text-align: justify; \">Adicionar as farinhas e envolver com cuidado para não formar grumos.<br></p>', 33),
(6, '<p style=\"text-align: justify; \">Colocar o preparado no tabuleiro e levar ao forno pré-aquecido 180º durante cerca de 20m ou até ficar a massa firme e húmida (mas sem colar no palito).<br></p>', 33),
(7, '<p style=\"text-align: justify;\">Quando estiver cozida desenformar para uma forma de papel vegetal e enrolar. Quando arrefecer polvilhar com açúcar a gosto.</p>', 33),
(5, '<p style=\"text-align: justify; \">Por último adicionar o chocolate reservado e programar 10seg/colher inversa vel.2,5.<br></p>', 34),
(6, '<p style=\"text-align: justify; \">Distribuir a massa em forminhas de papel previamente colocadas em formas de alumínio ou silicone e levar ao forno a 200° durante 30 a 35min (verificar com o palito se estão cozidos).<br></p>', 34),
(3, '<p style=\"text-align: justify; \">No copo limpo colocar a borboleta e adicionar os ovos, o açúcar e o óleo e programar 5min/temp.37°/vel.3.<br></p>', 34),
(4, '<p style=\"text-align: justify; \">Adicionar a cenoura reservada, a farinha, o fermento e o bicarbonato e programar 10seg/vel.3. <br></p>', 34),
(2, '<p style=\"text-align: justify; \">Limpe o copo da bimby. Não é necessário lavar (costumo limpar com papel de cozinha, apenas para tirar o pó do chocolate). </p><p style=\"text-align: justify; \">Coloque a cenoura cortada aos bocados e programe 10seg/vel.7, baixe o que ficou nas paredes do copo e programe mais 5seg/vel.7. Reserve.</p>', 34),
(1, '<p style=\"text-align: justify; \">Comece por pré-aquecer o forno a 200°. </p><p style=\"text-align: justify; \">Coloque no copo o chocolate partido aos bocados e programe 6seg/vel.5. Reserve. Se alguns bocados estiverem grandes, deixe apenas esses no copo e volte a programar mais 5seg/vel.5.</p>', 34),
(1, '<p style=\"text-align: justify; \">Coloque no copo o pão e pulverize 12 seg/vel 7. Retire e reserve.<br></p>', 35),
(2, '<p style=\"text-align: justify; \">Coloque num recipiente o leite e as sobras de pão e reserve.<br></p>', 35),
(3, '<p style=\"text-align: justify; \">Coloque no copo o chouriço e pique 5 seg/vel 5.<br></p>', 35),
(4, '<p style=\"text-align: justify; \">Adicione a carne, a salsa, o pão demolhado e programe 10 seg/vel 7.<br></p>', 35),
(5, '<p style=\"text-align: justify; \">Adicione o ovo, o sal, a pimenta e a noz-moscada e programe 15 seg/vel 3. Retire, forme bolas pequenas e passe-as pelo pão ralado reservado. Coloque-as no cesto e reserve.<br></p>', 35),
(6, '<p style=\"text-align: justify; \"><b>Molho</b></p><p style=\"text-align: justify; \">Coloque no copo a cebola, o alho, o tomate e o azeite, pique 5 seg/vel 5 e refogue 5 min/Varoma/vel 1.<br><br></p>', 35),
(7, '<p><b>Molho</b></p><p>Adicione a água, o vinho, o sal e a pimenta e bata 20 seg/vel 7.<br></p>', 35),
(8, '<p style=\"text-align: justify; \"><b>Molho</b></p><p style=\"text-align: justify; \">Coloque o cesto no copo e programe 20 min/Varoma/vel 2. Sirva de seguida.<br></p>', 35),
(1, '<p style=\"text-align: justify; \">Pré-aqueça o forno a 180º.<br></p>', 36),
(2, '<p style=\"text-align: justify;\">Colocar no copo da bimby a manteiga e a manteiga de amendoim, programar 15 seg/vel 3.<br></p>', 36),
(3, '<p style=\"text-align: justify; \">Juntar os açúcares e o ovo, programar 10 seg/vel3.<br></p>', 36),
(4, '<p style=\"text-align: justify; \">Juntar os secos, a farinha, o sal grosso e o bicabordato de sódio e envoolver 15 seg/vel 3.<br></p>', 36),
(5, '<p style=\"text-align: justify; \">Moldar bolinhas da massa, coloca-las sobre um tabuleiro forrado com papel vegetal, espaçadamente para não colarem no forno.&nbsp;<br></p>', 36),
(6, '<p style=\"text-align: justify; \">Pressionar cada bolinha com o polegar e, com um garfo fazer marcações cruzadas sobre a massa das bolachas, para que tenham um aspecto caraterístico das cookies americanas.&nbsp;<br></p>', 36),
(7, '<p style=\"text-align: justify; \">Levar ao forno por 8 a 10 min a 180ºC.<br></p>', 36),
(8, '<p style=\"text-align: justify; \">Findo este tempo, retirá-las do forno e deixar arrefecer.<br></p>', 36);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mk_date` date NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'user',
  `valid` varchar(10) NOT NULL DEFAULT 'false',
  `validation_code` varchar(250) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`name`, `email`, `password`, `mk_date`, `type`, `valid`, `validation_code`, `id`) VALUES
('Bernardo Ferreira', 'bernardobf2000@gmail.com', '5a79cba790f1e78006ae91bb5a6a700f9813540e', '2018-06-22', 'user', 'true', '', 1),
('Matilde Batista', 'matildebatista1973@gmail.com', 'fd5d9a37df54707f95f40a46e16b3eb275c71b8b', '2018-06-22', 'user', 'true', '', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
