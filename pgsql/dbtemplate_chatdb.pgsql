--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3 (Debian 15.3-1.pgdg110+1)
-- Dumped by pg_dump version 15.3 (Debian 15.3-1.pgdg110+1)

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
    src character varying(255)
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
1686686014	new chat	this is a filler message given on chat creation	1
\.


--
-- Data for Name: _chats; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public._chats (title, usersonline, lastactivetime, creationtime, id, description) FROM stdin;
default chat	0	0	0	1	the default chat
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

COPY public._images (id, imgname, src) FROM stdin;
\.


--
-- Data for Name: _users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public._users (username, creationtime, lastactivetime, description) FROM stdin;
\.


--
-- Name: _1_id_seq; Type: SEQUENCE SET; Schema: chats; Owner: postgres
--

SELECT pg_catalog.setval('chats._1_id_seq', 1, true);


--
-- Name: _chats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public._chats_id_seq', 1, false);


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

