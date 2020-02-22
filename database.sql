--
-- PostgreSQL database dump
--

-- Dumped from database version 10.8 (Ubuntu 10.8-1.pgdg16.04+1)
-- Dumped by pg_dump version 10.8 (Ubuntu 10.8-1.pgdg16.04+1)

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
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: assign; Type: TABLE; Schema: public; Owner: borland
--

CREATE TABLE public.assign (
    equally real,
    least_one real,
    preferred real,
    CONSTRAINT assign_equally_check CHECK (((equally <= (1)::double precision) AND (equally >= (0)::double precision))),
    CONSTRAINT assign_least_one_check CHECK (((least_one <= (1)::double precision) AND (least_one >= (0)::double precision))),
    CONSTRAINT assign_preferred_check CHECK (((preferred <= (1)::double precision) AND (preferred >= (0)::double precision))),
    CONSTRAINT max_value CHECK (((((equally + least_one) + preferred) >= (0.99)::double precision) AND (((equally + least_one) + preferred) <= (1.01)::double precision)))
);


ALTER TABLE public.assign OWNER TO borland;

--
-- Name: gems; Type: TABLE; Schema: public; Owner: borland
--

CREATE TABLE public.gems (
    id integer NOT NULL,
    gem_type_id integer,
    extraction_date date DEFAULT CURRENT_DATE,
    assignment_date date,
    confirmation_date date,
    dwarf_id integer,
    master_id integer,
    by_hand boolean,
    elf_id integer,
    status text DEFAULT 'не назначена'::text NOT NULL,
    deleted boolean DEFAULT false,
    CONSTRAINT gems_status_check CHECK ((status = ANY (ARRAY['назначена'::text, 'подтверждена'::text, 'не назначена'::text])))
);


ALTER TABLE public.gems OWNER TO borland;

--
-- Name: gems_types; Type: TABLE; Schema: public; Owner: borland
--

CREATE TABLE public.gems_types (
    id integer NOT NULL,
    type text NOT NULL,
    deleted boolean DEFAULT false,
    CONSTRAINT gems_type_check CHECK ((type <> ''::text))
);


ALTER TABLE public.gems_types OWNER TO borland;

--
-- Name: gems_id_seq; Type: SEQUENCE; Schema: public; Owner: borland
--

CREATE SEQUENCE public.gems_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gems_id_seq OWNER TO borland;

--
-- Name: gems_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: borland
--

ALTER SEQUENCE public.gems_id_seq OWNED BY public.gems_types.id;


--
-- Name: gems_id_seq1; Type: SEQUENCE; Schema: public; Owner: borland
--

CREATE SEQUENCE public.gems_id_seq1
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gems_id_seq1 OWNER TO borland;

--
-- Name: gems_id_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: borland
--

ALTER SEQUENCE public.gems_id_seq1 OWNED BY public.gems.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: borland
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(50),
    password character varying(255) NOT NULL,
    name character varying(50) NOT NULL,
    registration_date date DEFAULT CURRENT_DATE,
    authorization_date date DEFAULT CURRENT_DATE,
    status character varying(15) DEFAULT 'active'::character varying,
    deletion_date date,
    race character varying(15),
    master boolean DEFAULT false,
    description text DEFAULT 'Тут пока ничего нет'::text,
    CONSTRAINT users_email_check CHECK (((email)::text ~ '@'::text)),
    CONSTRAINT users_race_check CHECK (((race)::text = ANY (ARRAY[('elf'::character varying)::text, ('dwarf'::character varying)::text]))),
    CONSTRAINT users_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('deleted'::character varying)::text])))
);


ALTER TABLE public.users OWNER TO borland;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: borland
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO borland;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: borland
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: wishes; Type: TABLE; Schema: public; Owner: borland
--

CREATE TABLE public.wishes (
    elf_id integer,
    gem_type_id integer,
    wish real DEFAULT 0,
    CONSTRAINT wishes_wish_check CHECK (((wish >= (0)::double precision) AND (wish <= (1)::double precision)))
);


ALTER TABLE public.wishes OWNER TO borland;

--
-- Name: gems id; Type: DEFAULT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems ALTER COLUMN id SET DEFAULT nextval('public.gems_id_seq1'::regclass);


--
-- Name: gems_types id; Type: DEFAULT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems_types ALTER COLUMN id SET DEFAULT nextval('public.gems_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: assign; Type: TABLE DATA; Schema: public; Owner: borland
--

COPY public.assign (equally, least_one, preferred) FROM stdin;
0.330000013	0.330000013	0.340000004
\.


--
-- Data for Name: gems; Type: TABLE DATA; Schema: public; Owner: borland
--

COPY public.gems (id, gem_type_id, extraction_date, assignment_date, confirmation_date, dwarf_id, master_id, by_hand, elf_id, status, deleted) FROM stdin;
30	1	2019-06-14	2019-06-21	2019-06-21	1	1	f	8	подтверждена	f
51	19	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
2	2	2019-06-06	2019-06-10	\N	1	1	f	2	назначена	f
1	1	2019-06-06	2019-06-10	\N	1	1	f	2	назначена	f
14	4	2019-06-06	2019-06-10	2019-06-20	1	1	t	8	подтверждена	f
25	4	2019-06-07	2019-06-10	2019-06-20	6	1	t	8	подтверждена	f
7	3	2019-06-06	2019-06-10	2019-06-19	1	1	t	8	подтверждена	f
15	4	2019-06-06	2019-06-19	2019-06-20	1	1	t	8	подтверждена	f
11	4	2019-06-06	2019-06-10	2019-06-20	1	1	f	8	подтверждена	f
36	3	2019-06-17	2019-06-19	2019-06-20	1	1	t	8	подтверждена	f
9	3	2019-06-06	2019-06-10	2019-06-21	1	1	f	3	подтверждена	f
22	1	2019-06-07	2019-06-10	\N	6	1	t	3	назначена	f
21	1	2019-06-07	2019-06-10	\N	6	1	t	8	назначена	f
17	4	2019-06-06	2019-06-10	\N	1	1	t	7	назначена	f
6	3	2019-06-06	2019-06-10	2019-06-21	1	1	f	3	подтверждена	f
16	4	2019-06-06	2019-06-10	2019-06-21	1	1	t	3	подтверждена	f
50	19	2019-06-21	2019-06-21	\N	6	1	f	8	назначена	f
13	4	2019-06-06	2019-06-21	\N	1	1	f	3	назначена	f
23	3	2019-06-07	2019-06-21	\N	6	1	f	2	назначена	f
10	4	2019-06-06	2019-06-10	2019-06-12	1	1	f	2	подтверждена	f
26	2	2019-06-07	2019-06-21	\N	6	1	t	7	назначена	f
85	2	2019-06-22	2019-06-22	2019-06-22	6	1	t	30	подтверждена	f
86	2	2019-06-22	2019-06-22	2019-06-22	6	1	t	30	подтверждена	f
87	2	2019-06-22	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
88	1	2019-06-22	2019-06-22	2019-06-22	6	1	t	30	подтверждена	f
89	1	2019-06-22	2019-06-22	2019-06-22	6	1	t	30	подтверждена	f
83	3	2019-06-22	2019-06-22	2019-06-22	6	1	t	30	подтверждена	f
27	2	2019-06-07	2019-06-21	\N	6	1	t	7	назначена	f
29	2	2019-06-07	2019-06-21	\N	6	1	f	3	назначена	f
31	4	2019-06-14	2019-06-21	\N	1	1	t	7	назначена	f
84	3	2019-06-22	2019-06-22	2019-06-22	6	1	t	30	подтверждена	f
4	2	2019-06-06	2019-06-10	\N	1	1	f	2	назначена	f
20	1	2019-06-07	2019-06-10	\N	6	1	t	7	назначена	f
28	2	2019-06-07	2019-06-10	\N	6	1	f	7	назначена	f
5	2	2019-06-06	2019-06-10	\N	1	1	t	8	назначена	f
24	3	2019-06-07	2019-06-21	2019-06-21	6	1	t	7	подтверждена	f
81	4	2019-06-22	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
82	4	2019-06-22	2019-06-22	2019-06-22	6	1	t	30	подтверждена	f
32	3	2019-06-14	2019-06-21	2019-06-21	1	1	t	7	подтверждена	f
33	3	2019-06-14	2019-06-21	2019-06-21	1	1	t	7	подтверждена	f
34	3	2019-06-14	2019-06-21	2019-06-21	1	1	f	7	подтверждена	f
35	3	2019-06-14	2019-06-21	2019-06-21	1	1	t	7	подтверждена	f
37	3	2019-06-17	2019-06-21	2019-06-21	1	1	f	7	подтверждена	f
38	3	2019-06-17	2019-06-21	2019-06-21	1	1	t	7	подтверждена	f
57	20	2019-06-21	2019-06-22	\N	6	1	f	2	назначена	f
59	20	2019-06-21	2019-06-22	\N	6	1	f	2	назначена	f
60	20	2019-06-21	2019-06-22	\N	6	1	f	3	назначена	f
62	19	2019-06-21	2019-06-22	\N	6	1	f	2	назначена	f
63	19	2019-06-21	2019-06-22	\N	6	1	f	3	назначена	f
65	19	2019-06-21	2019-06-22	\N	6	1	f	2	назначена	f
66	19	2019-06-21	2019-06-22	\N	6	1	f	3	назначена	f
68	19	2019-06-21	2019-06-22	\N	6	1	f	2	назначена	f
69	19	2019-06-21	2019-06-22	\N	6	1	f	3	назначена	f
71	21	2019-06-21	2019-06-22	\N	6	1	f	8	назначена	f
72	21	2019-06-21	2019-06-22	\N	6	1	f	2	назначена	f
73	21	2019-06-21	2019-06-22	\N	6	1	f	3	назначена	f
75	21	2019-06-21	2019-06-22	\N	6	1	f	8	назначена	f
76	21	2019-06-21	2019-06-22	\N	6	1	f	2	назначена	f
77	21	2019-06-21	2019-06-22	\N	6	1	f	3	назначена	f
79	21	2019-06-21	2019-06-22	\N	6	1	f	8	назначена	f
80	21	2019-06-21	2019-06-22	\N	6	1	f	2	назначена	f
53	20	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
54	20	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
55	20	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
56	20	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
58	20	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
61	20	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
64	19	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
67	19	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
70	21	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
74	21	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
78	21	2019-06-21	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
90	4	2019-06-22	\N	\N	6	\N	\N	\N	не назначена	t
93	3	2019-06-22	2019-06-22	\N	1	1	f	7	назначена	f
94	21	2019-06-22	2019-06-22	\N	1	1	t	8	назначена	f
91	20	2019-06-22	2019-06-22	2019-06-22	1	1	f	30	подтверждена	f
92	4	2019-06-22	2019-06-22	\N	1	1	f	7	назначена	f
95	4	2019-06-22	2019-06-22	\N	6	1	f	3	назначена	f
96	4	2019-06-22	2019-06-22	\N	6	1	f	2	назначена	f
97	4	2019-06-22	2019-06-22	\N	6	1	f	8	назначена	f
98	3	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
99	3	2019-06-22	2019-06-22	\N	6	1	f	3	назначена	f
100	3	2019-06-22	2019-06-22	\N	6	1	f	2	назначена	f
101	1	2019-06-22	2019-06-22	\N	6	1	f	8	назначена	f
102	1	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
103	1	2019-06-22	2019-06-22	\N	6	1	f	3	назначена	f
104	20	2019-06-22	2019-06-22	\N	6	1	f	2	назначена	f
105	20	2019-06-22	2019-06-22	\N	6	1	f	3	назначена	f
106	20	2019-06-22	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
109	4	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
110	4	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
108	4	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
111	2	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
112	1	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
113	1	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
114	1	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
115	1	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
116	20	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
117	20	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
118	20	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
119	20	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
120	20	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
121	20	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
122	21	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
125	21	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
126	21	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
127	19	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
128	19	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
129	19	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
130	19	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
131	19	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	f
107	4	2019-06-22	2019-06-22	2019-06-22	6	1	f	30	подтверждена	f
123	21	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	t
124	21	2019-06-22	2019-06-22	\N	6	1	f	7	назначена	t
132	4	2020-02-22	\N	\N	1	\N	\N	\N	не назначена	f
133	4	2020-02-22	\N	\N	1	\N	\N	\N	не назначена	f
135	4	2020-02-22	2020-02-22	\N	1	1	f	3	назначена	f
136	1	2020-02-22	2020-02-22	\N	1	1	f	8	назначена	f
137	1	2020-02-22	2020-02-22	\N	1	1	f	2	назначена	f
138	1	2020-02-22	2020-02-22	\N	1	1	f	3	назначена	f
139	20	2020-02-22	2020-02-22	\N	1	1	f	8	назначена	f
140	20	2020-02-22	2020-02-22	\N	1	1	f	2	назначена	f
141	20	2020-02-22	2020-02-22	\N	1	1	f	3	назначена	f
142	21	2020-02-22	2020-02-22	\N	1	1	f	8	назначена	f
143	21	2020-02-22	2020-02-22	\N	1	1	f	2	назначена	f
134	4	2020-02-22	2020-02-22	\N	1	1	f	2	назначена	f
\.


--
-- Data for Name: gems_types; Type: TABLE DATA; Schema: public; Owner: borland
--

COPY public.gems_types (id, type, deleted) FROM stdin;
4	Алмаз	f
3	Корунд	f
2	Кварц	f
1	Топаз	f
20	Киноварь	f
21	Флюорит	f
19	Гематит	f
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: borland
--

COPY public.users (id, email, password, name, registration_date, authorization_date, status, deletion_date, race, master, description) FROM stdin;
7	aramis@aramis.ru	$2y$10$UGfreuTWI2aD8piVtbKLfexuYu6.tsARp/FX5XWo7PfX48Jnxq0iu	Арамис	2019-06-08	2019-06-21	deleted	2019-06-17	elf	f	Тут пока ничего нет!
8	legalas@cool.ru	$2y$10$qRnM9ONRkMo2xAlfaUua9.j2sbVCAQ6VQxQV8VaC/okfYpbmR2AOq	Легалаз	2019-06-08	2019-06-21	active	\N	elf	f	Тут пока ничего нет!
2	ailin@mail.ru	$2y$10$2BjpMwBsMBbzI.gCtl6tDunVaIGUnN.zpE6U1AFSrgI7AG9QWYID6	Айлинэль	2019-05-01	2019-06-14	active	\N	elf	f	Тут пока ничего нет!
3	dark@mail.ru	$2y$10$eeXSuUXcK/hyl6e7W.8WteTnogZu7hfAiFQnMz3T8YiwL6F0qcOyO	Тёмный эльф	2019-05-10	2019-06-21	active	\N	elf	f	Тут пока ничего нет!
29	gimli@email.ru	$2y$10$ePufzAJ8BxrxxvLstOlF1ePiSrmQxEgcX0eZTg6/YIjNXCR9eenJ.	Гимли	2019-06-21	2019-06-21	active	\N	dwarf	f	Тут пока ничего нет!
6	ezhik@vtapkah.ru	$2y$10$Qsg.eXuen/cArDSndP3zQuIEEbpZIpI82uJ29u63TrvXoXQJxDy3u	Ёжик в тапочках	2019-06-07	2019-06-22	active	\N	dwarf	f	Тут пока ничего нет!
30	elf@mail.ru	$2y$10$9unNqSDShLeOU6ZSu0X0VugxRPFTqi.dO6cAHXcFaUWfNEpedGoaG	Амрас	2019-06-21	2019-07-14	active	\N	elf	f	Тут пока ничего нет!
1	admin@admin.ru	$2y$10$lTJ7wzej4wLiwGfs8tsBTOp5/Pq5Dy8zq0Kb9Tiqcyibc8ERYqmce	administrator	2019-05-01	2020-02-22	active	\N	dwarf	t	Я админ! Я власть!
\.


--
-- Data for Name: wishes; Type: TABLE DATA; Schema: public; Owner: borland
--

COPY public.wishes (elf_id, gem_type_id, wish) FROM stdin;
3	4	0.49000001
3	3	0.0599999987
3	2	0.390000015
3	1	0.0599999987
3	19	0
8	4	0.189999998
8	3	0.219999999
8	2	0.420000017
8	1	0.170000002
8	19	0
2	4	0.310000002
2	3	0.310000002
2	2	0.310000002
2	1	0.0700000003
2	19	0
7	4	0.310000002
7	3	0.310000002
7	2	0.310000002
7	1	0.0700000003
7	19	0
2	21	0
3	21	0
7	21	0
8	21	0
3	20	0
8	20	0
2	20	0
7	20	0
30	3	0
30	2	0
30	1	0
30	20	0.379999995
30	19	0
30	21	0
30	4	0.620000005
\.


--
-- Name: gems_id_seq; Type: SEQUENCE SET; Schema: public; Owner: borland
--

SELECT pg_catalog.setval('public.gems_id_seq', 21, true);


--
-- Name: gems_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: borland
--

SELECT pg_catalog.setval('public.gems_id_seq1', 143, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: borland
--

SELECT pg_catalog.setval('public.users_id_seq', 30, true);


--
-- Name: gems_types gems_pkey; Type: CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems_types
    ADD CONSTRAINT gems_pkey PRIMARY KEY (id);


--
-- Name: gems gems_pkey1; Type: CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems
    ADD CONSTRAINT gems_pkey1 PRIMARY KEY (id);


--
-- Name: gems_types must_be_different; Type: CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems_types
    ADD CONSTRAINT must_be_different UNIQUE (type);


--
-- Name: users uniq_email; Type: CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT uniq_email UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: gems gems_elf_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems
    ADD CONSTRAINT gems_elf_id_fkey FOREIGN KEY (elf_id) REFERENCES public.users(id);


--
-- Name: gems gems_gem_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems
    ADD CONSTRAINT gems_gem_type_id_fkey FOREIGN KEY (gem_type_id) REFERENCES public.gems_types(id);


--
-- Name: gems gems_gnom_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems
    ADD CONSTRAINT gems_gnom_id_fkey FOREIGN KEY (dwarf_id) REFERENCES public.users(id);


--
-- Name: gems gems_master_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.gems
    ADD CONSTRAINT gems_master_id_fkey FOREIGN KEY (master_id) REFERENCES public.users(id);


--
-- Name: wishes wishes_gem_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.wishes
    ADD CONSTRAINT wishes_gem_type_id_fkey FOREIGN KEY (gem_type_id) REFERENCES public.gems_types(id);


--
-- Name: wishes wishes_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: borland
--

ALTER TABLE ONLY public.wishes
    ADD CONSTRAINT wishes_user_id_fkey FOREIGN KEY (elf_id) REFERENCES public.users(id);


--
-- PostgreSQL database dump complete
--

