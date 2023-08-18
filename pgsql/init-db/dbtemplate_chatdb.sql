--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2 (Debian 15.2-1.pgdg110+1)
-- Dumped by pg_dump version 15.2 (Debian 15.2-1.pgdg110+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: chats; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA chats;


ALTER SCHEMA chats OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: _1; Type: TABLE; Schema: chats; Owner: postgres
--

CREATE TABLE chats._1 (
    timedelivered bigint,
    by character varying(255),
    message character varying(2000),
    id integer NOT NULL
);


ALTER TABLE chats._1 OWNER TO postgres;

--
-- Name: _1_id_seq; Type: SEQUENCE; Schema: chats; Owner: postgres
--

CREATE SEQUENCE chats._1_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE chats._1_id_seq OWNER TO postgres;

--
-- Name: _1_id_seq; Type: SEQUENCE OWNED BY; Schema: chats; Owner: postgres
--

ALTER SEQUENCE chats._1_id_seq OWNED BY chats._1.id;


--
-- Name: _6; Type: TABLE; Schema: chats; Owner: postgres
--

CREATE TABLE chats._6 (
    timedelivered bigint,
    by character varying(255),
    message character varying(2000),
    id integer NOT NULL
);


ALTER TABLE chats._6 OWNER TO postgres;

--
-- Name: _6_id_seq; Type: SEQUENCE; Schema: chats; Owner: postgres
--

CREATE SEQUENCE chats._6_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE chats._6_id_seq OWNER TO postgres;

--
-- Name: _6_id_seq; Type: SEQUENCE OWNED BY; Schema: chats; Owner: postgres
--

ALTER SEQUENCE chats._6_id_seq OWNED BY chats._6.id;


--
-- Name: _8; Type: TABLE; Schema: chats; Owner: postgres
--

CREATE TABLE chats._8 (
    timedelivered bigint,
    by character varying(255),
    message character varying(2000),
    id integer NOT NULL
);


ALTER TABLE chats._8 OWNER TO postgres;

--
-- Name: _8_id_seq; Type: SEQUENCE; Schema: chats; Owner: postgres
--

CREATE SEQUENCE chats._8_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE chats._8_id_seq OWNER TO postgres;

--
-- Name: _8_id_seq; Type: SEQUENCE OWNED BY; Schema: chats; Owner: postgres
--

ALTER SEQUENCE chats._8_id_seq OWNED BY chats._8.id;


--
-- Name: _chats; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public._chats (
    title character varying(255) NOT NULL,
    usersonline integer NOT NULL,
    lastactivetime bigint,
    creationtime bigint,
    id integer NOT NULL,
    description character varying(2000)
);


ALTER TABLE public._chats OWNER TO postgres;

--
-- Name: _chats_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public._chats_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public._chats_id_seq OWNER TO postgres;

--
-- Name: _chats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public._chats_id_seq OWNED BY public._chats.id;


--
-- Name: _chattemplate; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public._chattemplate (
    timedelivered bigint NOT NULL,
    by character varying(255) NOT NULL,
    message character varying(2000) NOT NULL
);


ALTER TABLE public._chattemplate OWNER TO postgres;

--
-- Name: _images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public._images (
    id integer NOT NULL,
    imgname character varying(512) NOT NULL,
    img bytea
);


ALTER TABLE public._images OWNER TO postgres;

--
-- Name: _images_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public._images_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public._images_id_seq OWNER TO postgres;

--
-- Name: _images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public._images_id_seq OWNED BY public._images.id;


--
-- Name: _users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public._users (
    username character varying(255) NOT NULL,
    creationtime bigint NOT NULL,
    lastactivetime bigint NOT NULL,
    description character varying(500)
);


ALTER TABLE public._users OWNER TO postgres;

--
-- Name: _1 id; Type: DEFAULT; Schema: chats; Owner: postgres
--

ALTER TABLE ONLY chats._1 ALTER COLUMN id SET DEFAULT nextval('chats._1_id_seq'::regclass);


--
-- Name: _6 id; Type: DEFAULT; Schema: chats; Owner: postgres
--

ALTER TABLE ONLY chats._6 ALTER COLUMN id SET DEFAULT nextval('chats._6_id_seq'::regclass);


--
-- Name: _8 id; Type: DEFAULT; Schema: chats; Owner: postgres
--

ALTER TABLE ONLY chats._8 ALTER COLUMN id SET DEFAULT nextval('chats._8_id_seq'::regclass);


--
-- Name: _chats id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public._chats ALTER COLUMN id SET DEFAULT nextval('public._chats_id_seq'::regclass);


--
-- Name: _images id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public._images ALTER COLUMN id SET DEFAULT nextval('public._images_id_seq'::regclass);


--
-- Data for Name: _1; Type: TABLE DATA; Schema: chats; Owner: postgres
--

COPY chats._1 (timedelivered, by, message, id) FROM stdin;
1686697049	meowas	1\r\n	12
1686697054	meowas	2\r\n	13
1686697069	meowas	3\r\n	14
1686697502	meowas	4	15
1686697677	meowas	5	16
1686697801	meowas	6	17
1686697805	meowas	7	18
1686697805	meowas	7	19
1686697805	meowas	7	20
1686697805	meowas	7	21
1686697806	meowas	7	22
1686697806	meowas	7	23
1686697818	meowas	8\r\n	24
1686697847	meowas	9	25
1686697849	meowas	9	26
1686697849	meowas	9	27
1686697849	meowas	9	28
1686697850	meowas	9	29
1686697850	meowas	9	30
1686697851	meowas	9	31
1686697851	meowas	9	32
1686697888	timmy	asdasd	33
1688520746	21321	hello\r\n	34
1691610686	lasting forkful	toot	35
\.


--
-- Data for Name: _6; Type: TABLE DATA; Schema: chats; Owner: postgres
--

COPY chats._6 (timedelivered, by, message, id) FROM stdin;
1686686014	new chat	this is a filler message given on chat creation	1
\.


--
-- Data for Name: _8; Type: TABLE DATA; Schema: chats; Owner: postgres
--

COPY chats._8 (timedelivered, by, message, id) FROM stdin;
1686686014	new chat	this is a filler message given on chat creation	1
\.


--
-- Data for Name: _chats; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public._chats (title, usersonline, lastactivetime, creationtime, id, description) FROM stdin;
a	3	1686417720	1686417720	7	\N
asdas	1	1686688275	1686688275	8	\N
title	0	1686417448	1686417448	2	\N
asa	1	1686417461	1686417461	3	\N
fff	1	1686417547	1686417547	4	\N
default chat	6	1691610686	1686344746	1	
asdasd	1	1686417621	1686417621	5	\N
cat	7	1686417652	1686417652	6	\N
\.


--
-- Data for Name: _chattemplate; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public._chattemplate (timedelivered, by, message) FROM stdin;
1686686014	new chat	this is a filler message given on chat creation
\.


--
-- Data for Name: _images; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public._images (id, imgname, img) FROM stdin;
\.


--
-- Data for Name: _users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public._users (username, creationtime, lastactivetime, description) FROM stdin;
lasting forkful	1691607446	-1	PDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO::FETCH_ASSOCPDO:
buttery conversion	1685901269	1686177958	\N
genuine nexus	1685901270	1686177958	\N
meow	1685227676	-1	\N
chilly outline	1685901268	1686177958	\N
quarterly messaging	1685901287	1686180853	\N
overwrought unrest	1686180852	1686183167	\N
coarse pest	1686184667	1686185277	asdasdas
micro cat	1685986282	1686185291	mew mew mew!
meager quit	1685901689	-1	\N
cat	1685319331	-2	fart
glossy pattypan	1685901691	1686411971	\N
vital recliner	1685904010	1685907877	\N
tidy claw	1686411971	1686411976	\N
lumpy nobility	1685907877	1685928663	\N
considerate gangland	1686411976	1686411993	\N
zigzag xylophone	1685908670	1685928663	\N
novel deliciousness	1686411992	1686411996	\N
nonstop xbox	1686411996	1686411998	\N
gigantic noir	1686412000	-1	\N
oafish uterine	1686411998	1686412000	\N
shady barbara	1685901705	1686521675	\N
nondescript jeep	1686521675	1686521679	\N
pleased defeat	1686521679	1686521681	\N
determined zealot	1686521681	1686521684	\N
yellowish likes	1686521684	1686521687	\N
extra-large enrollment	1686521687	1686521690	\N
talkative zookeeper	1686521690	1686521692	\N
lethal gray	1686521692	1686521695	\N
xylographic wick	1686521695	1686521698	\N
easy nod	1686521697	1686521700	\N
known ruling	1686521699	1686521703	\N
xylographic compulsion	1686521705	-1	\N
bleak frock	1686521703	1686521705	\N
double zombie	1685901707	-1	\N
quaint microphone	1685901710	-1	\N
negative quill	1685901712	-1	\N
holistic vaulting	1685901724	-1	\N
timmy	1686697869	-1	\N
meowas	1685900713	1686697869	\N
21321	1685900052	-1	\N
scrawny nitrogen	1685901726	1691607427	\N
xenophobic representative	1691607427	1691607434	\N
euphoric zodiac	1691607434	1691607436	\N
xylographic increase	1691607436	1691607438	\N
ornery abandonment	1691607437	1691607440	\N
nutty interruption	1691607440	1691607443	\N
strange incubation	1691607443	1691607445	\N
proud connotation	1691607445	1691607447	\N
\.


--
-- Name: _1_id_seq; Type: SEQUENCE SET; Schema: chats; Owner: postgres
--

SELECT pg_catalog.setval('chats._1_id_seq', 35, true);


--
-- Name: _6_id_seq; Type: SEQUENCE SET; Schema: chats; Owner: postgres
--

SELECT pg_catalog.setval('chats._6_id_seq', 1, true);


--
-- Name: _8_id_seq; Type: SEQUENCE SET; Schema: chats; Owner: postgres
--

SELECT pg_catalog.setval('chats._8_id_seq', 1, true);


--
-- Name: _chats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public._chats_id_seq', 8, true);


--
-- Name: _images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public._images_id_seq', 1, false);


--
-- Name: _1 _1_pkey; Type: CONSTRAINT; Schema: chats; Owner: postgres
--

ALTER TABLE ONLY chats._1
    ADD CONSTRAINT _1_pkey PRIMARY KEY (id);


--
-- Name: _6 _6_pkey; Type: CONSTRAINT; Schema: chats; Owner: postgres
--

ALTER TABLE ONLY chats._6
    ADD CONSTRAINT _6_pkey PRIMARY KEY (id);


--
-- Name: _8 _8_pkey; Type: CONSTRAINT; Schema: chats; Owner: postgres
--

ALTER TABLE ONLY chats._8
    ADD CONSTRAINT _8_pkey PRIMARY KEY (id);


--
-- Name: _chats _chats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public._chats
    ADD CONSTRAINT _chats_pkey PRIMARY KEY (id);


--
-- Name: _chattemplate _chattemplate_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public._chattemplate
    ADD CONSTRAINT _chattemplate_pkey PRIMARY KEY (timedelivered);


--
-- Name: _images _images_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public._images
    ADD CONSTRAINT _images_pkey PRIMARY KEY (id);


--
-- Name: _users _users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public._users
    ADD CONSTRAINT _users_pkey PRIMARY KEY (username);


--
-- PostgreSQL database dump complete
--

