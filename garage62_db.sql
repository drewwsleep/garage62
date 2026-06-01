--
-- PostgreSQL database dump
--

\restrict 3APsHgCBzWjHAIlnTsBNDxRxGQsgYoqoMxAgblwsPYSXR9mgHoabgKJKg9UeEVa

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.6

-- Started on 2026-06-01 21:01:52

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 224 (class 1259 OID 24616)
-- Name: car_models; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.car_models (
    id integer NOT NULL,
    brand character varying(100) NOT NULL,
    model character varying(100) NOT NULL
);


ALTER TABLE public.car_models OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 24615)
-- Name: car_models_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.car_models_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.car_models_id_seq OWNER TO postgres;

--
-- TOC entry 5024 (class 0 OID 0)
-- Dependencies: 223
-- Name: car_models_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.car_models_id_seq OWNED BY public.car_models.id;


--
-- TOC entry 226 (class 1259 OID 24628)
-- Name: cars; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cars (
    id integer NOT NULL,
    model_id integer NOT NULL,
    year integer,
    price numeric(10,2) NOT NULL,
    image_url character varying(255),
    color character varying(50),
    features text,
    services text
);


ALTER TABLE public.cars OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 24627)
-- Name: cars_new_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cars_new_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cars_new_id_seq OWNER TO postgres;

--
-- TOC entry 5025 (class 0 OID 0)
-- Dependencies: 225
-- Name: cars_new_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cars_new_id_seq OWNED BY public.cars.id;


--
-- TOC entry 222 (class 1259 OID 16437)
-- Name: order_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_items (
    id integer NOT NULL,
    order_id integer NOT NULL,
    car_id integer NOT NULL,
    quantity integer DEFAULT 1,
    unit_price numeric(10,2) NOT NULL,
    total_price numeric(10,2) NOT NULL
);


ALTER TABLE public.order_items OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16436)
-- Name: order_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.order_items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.order_items_id_seq OWNER TO postgres;

--
-- TOC entry 5026 (class 0 OID 0)
-- Dependencies: 221
-- Name: order_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.order_items_id_seq OWNED BY public.order_items.id;


--
-- TOC entry 220 (class 1259 OID 16415)
-- Name: orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    user_id integer NOT NULL,
    car_id integer,
    order_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    start_date date NOT NULL,
    end_date date NOT NULL,
    total_price numeric(10,2) NOT NULL
);


ALTER TABLE public.orders OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16414)
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.orders_id_seq OWNER TO postgres;

--
-- TOC entry 5027 (class 0 OID 0)
-- Dependencies: 219
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- TOC entry 218 (class 1259 OID 16390)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    email character varying(120) NOT NULL,
    password character varying(255) NOT NULL,
    role character varying(20) DEFAULT 'user'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16389)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 5028 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 4838 (class 2604 OID 24619)
-- Name: car_models id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.car_models ALTER COLUMN id SET DEFAULT nextval('public.car_models_id_seq'::regclass);


--
-- TOC entry 4839 (class 2604 OID 24631)
-- Name: cars id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cars ALTER COLUMN id SET DEFAULT nextval('public.cars_new_id_seq'::regclass);


--
-- TOC entry 4836 (class 2604 OID 16440)
-- Name: order_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items ALTER COLUMN id SET DEFAULT nextval('public.order_items_id_seq'::regclass);


--
-- TOC entry 4834 (class 2604 OID 16418)
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- TOC entry 4831 (class 2604 OID 16393)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 5016 (class 0 OID 24616)
-- Dependencies: 224
-- Data for Name: car_models; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.car_models (id, brand, model) FROM stdin;
1	Lada	Niva Bronto
2	Nissan	GT-R Nismo R34
3	Mazda	MX-5 IV
4	Mercedes	AMG GT
6	Porsche	Cayman GT4
7	BMW	M3 Touring
8	Porsche	911 GT3 RS
9	Ferrari	F40
5	Lada	Granta Sport
25	Hyundai	Solaris
22	Lada	Vesta Sport
\.


--
-- TOC entry 5018 (class 0 OID 24628)
-- Dependencies: 226
-- Data for Name: cars; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cars (id, model_id, year, price, image_url, color, features, services) FROM stdin;
3	1	2023	18000.00	/images/cars/niva_1.jpg	Чёрный	AWD; МКПП	\N
4	6	2022	228145.00	/images/cars/gt4_1.jpg	Серый	Подогрев сидений; МКПП	Двухсоставные кованые диски
5	2	1999	662208.00	/images/cars/GTR34_1.jpg	Белый	AWD; МКПП	Карбон пакет
6	7	2021	108700.00	/images/cars/m3_1.jpg	Зелёный	AWD	Карбон пакет; Алькантара
7	4	2020	409600.00	/images/cars/Benz_1.jpg	Серебристый	АКПП	Кожа; Панорамная крыша
8	5	2023	19568.00	images/granta_1.jpg	Чёрный	МКПП	\N
9	3	2015	32600.00	/images/cars/mazda_1.jpg	Красный	МКПП	Алькантара
14	25	2019	21456.00	https://avatars.mds.yandex.net/get-autoru-vos/17006437/76db8cf7a9954cc6ffb17050974e7049/1200x900	Серебристый	АКПП; 4 электростеклоподъемника; ПТФ	Литые диски; Антикор днища
13	22	2026	19342.00	https://avatars.mds.yandex.net/get-vertis-journal/3934100/_96A8192.jpg_1774340688230/orig	серый	МКПП	Black пакет
1	8	2023	241300.00	/images/cars/gt3_1.jpg	Серый	AWD	Карбон пакет; Алькантара
2	9	1987	3250990.00	/images/cars/F40_1.jpg	Красный	МКПП	Карбон пакет
\.


--
-- TOC entry 5014 (class 0 OID 16437)
-- Dependencies: 222
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.order_items (id, order_id, car_id, quantity, unit_price, total_price) FROM stdin;
1	1	9	1	32600.00	32600.00
2	1	8	1	19000.00	19000.00
3	2	9	1	32600.00	32600.00
4	2	8	1	19000.00	19000.00
5	3	5	1	662208.00	662208.00
6	4	5	1	662208.00	662208.00
7	5	9	1	32600.00	32600.00
8	6	8	1	19000.00	19000.00
9	7	13	1	20567.00	20567.00
10	8	2	1	3250990.00	3250990.00
11	9	3	1	18000.00	18000.00
12	9	6	1	108700.00	108700.00
13	10	13	1	19342.00	19342.00
\.


--
-- TOC entry 5012 (class 0 OID 16415)
-- Dependencies: 220
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.orders (id, user_id, car_id, order_date, start_date, end_date, total_price) FROM stdin;
1	2	9	2026-03-19 18:01:00.734864	2026-03-19	2026-03-20	77100.00
2	2	9	2026-03-19 18:01:12.88215	2026-03-19	2026-03-20	77100.00
3	4	5	2026-03-19 19:35:47.65919	2026-03-19	2026-03-20	687708.00
4	4	5	2026-03-19 19:35:50.417652	2026-03-19	2026-03-20	687708.00
5	4	9	2026-03-19 19:36:32.953436	2026-03-19	2026-03-20	58100.00
6	4	8	2026-03-19 19:44:46.51215	2026-03-19	2026-03-20	44500.00
7	2	13	2026-04-16 14:17:24.504754	2026-04-16	2026-04-17	20567.00
8	2	2	2026-04-16 14:18:30.650377	2026-04-16	2026-04-17	3250990.00
9	4	3	2026-04-16 14:24:41.891725	2026-04-16	2026-04-17	126700.00
10	2	13	2026-05-17 21:41:09.073539	2026-05-17	2026-05-18	19342.00
\.


--
-- TOC entry 5010 (class 0 OID 16390)
-- Dependencies: 218
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, password, role, created_at) FROM stdin;
1	Admin	admin@garage62.ru	admin123	admin	2026-03-19 16:00:56.009442
2	User	user@mail.ru	user12345	user	2026-03-19 16:00:56.009442
4	abc	abc@mail.ru	11111111	user	2026-03-19 18:06:32.411609
\.


--
-- TOC entry 5029 (class 0 OID 0)
-- Dependencies: 223
-- Name: car_models_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.car_models_id_seq', 30, true);


--
-- TOC entry 5030 (class 0 OID 0)
-- Dependencies: 225
-- Name: cars_new_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cars_new_id_seq', 14, true);


--
-- TOC entry 5031 (class 0 OID 0)
-- Dependencies: 221
-- Name: order_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.order_items_id_seq', 13, true);


--
-- TOC entry 5032 (class 0 OID 0)
-- Dependencies: 219
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_id_seq', 10, true);


--
-- TOC entry 5033 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 5, true);


--
-- TOC entry 4852 (class 2606 OID 24625)
-- Name: car_models car_models_brand_model_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.car_models
    ADD CONSTRAINT car_models_brand_model_key UNIQUE (brand, model);


--
-- TOC entry 4854 (class 2606 OID 24623)
-- Name: car_models car_models_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.car_models
    ADD CONSTRAINT car_models_pkey PRIMARY KEY (id);


--
-- TOC entry 4857 (class 2606 OID 24634)
-- Name: cars cars_new_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cars
    ADD CONSTRAINT cars_new_pkey PRIMARY KEY (id);


--
-- TOC entry 4850 (class 2606 OID 16443)
-- Name: order_items order_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_pkey PRIMARY KEY (id);


--
-- TOC entry 4847 (class 2606 OID 16424)
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- TOC entry 4842 (class 2606 OID 16401)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 4844 (class 2606 OID 16399)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 4855 (class 1259 OID 24626)
-- Name: idx_car_models_brand_model; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_car_models_brand_model ON public.car_models USING btree (brand, model);


--
-- TOC entry 4858 (class 1259 OID 24640)
-- Name: idx_cars_new_model_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_cars_new_model_id ON public.cars USING btree (model_id);


--
-- TOC entry 4848 (class 1259 OID 16454)
-- Name: idx_order_items_order_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_order_items_order_id ON public.order_items USING btree (order_id);


--
-- TOC entry 4845 (class 1259 OID 16435)
-- Name: idx_orders_user_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_orders_user_id ON public.orders USING btree (user_id);


--
-- TOC entry 4840 (class 1259 OID 16402)
-- Name: idx_users_email; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_users_email ON public.users USING btree (lower((email)::text));


--
-- TOC entry 4863 (class 2606 OID 24635)
-- Name: cars cars_new_model_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cars
    ADD CONSTRAINT cars_new_model_id_fkey FOREIGN KEY (model_id) REFERENCES public.car_models(id) ON DELETE CASCADE;


--
-- TOC entry 4861 (class 2606 OID 24641)
-- Name: order_items order_items_car_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_car_id_fkey FOREIGN KEY (car_id) REFERENCES public.cars(id) ON DELETE CASCADE;


--
-- TOC entry 4862 (class 2606 OID 16444)
-- Name: order_items order_items_order_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_order_id_fkey FOREIGN KEY (order_id) REFERENCES public.orders(id) ON DELETE CASCADE;


--
-- TOC entry 4859 (class 2606 OID 24646)
-- Name: orders orders_car_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_car_id_fkey FOREIGN KEY (car_id) REFERENCES public.cars(id) ON DELETE SET NULL;


--
-- TOC entry 4860 (class 2606 OID 16425)
-- Name: orders orders_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


-- Completed on 2026-06-01 21:01:52

--
-- PostgreSQL database dump complete
--

\unrestrict 3APsHgCBzWjHAIlnTsBNDxRxGQsgYoqoMxAgblwsPYSXR9mgHoabgKJKg9UeEVa

