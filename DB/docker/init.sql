create table jobs (
    job_id INTEGER primary key,
    job_name varchar(100) not null
);

create table departments (
    dept_id INTEGER primary key,
    dept_name varchar(100) not null
);

create table employees (
    e_id varchar(5) primary key,
    firstname varchar(100),
    lastname varchar(100),
    hire_date timestamp with time zone default current_timestamp,
    salary INTEGER,
    dept_id INTEGER not null,
    job_id INTEGER not null,
    constraint fk_dept_id foreign key (dept_id) references departments(dept_id),
    constraint fk_jobs_id foreign key (job_id) references jobs(job_id)
);

create table form_appraisal (
    form_id serial primary key,
    topic_id INTEGER not null unique,
    evalutor_id varchar(5) not null,
    evaluatee_id varchar(5) not null,
    constraint fk_evalutor foreign key (evalutor_id) references employees(e_id),
    constraint fk_evaluatee foreign key (evaluatee_id) references employees(e_id)
);

create table form_topic (
    topic_id INTEGER primary key,
    topic_name varchar(50) not null,
    subtopic_id INTEGER not null unique,
    constraint fk_topic_id foreign key (topic_id) references form_appraisal(topic_id)
);

create table form_subtopic (
    subtopic_id INTEGER primary key,
    subtopic_name varchar(50) not null,
    scores INTEGER,
    constraint fk_subtopic_id foreign key (subtopic_id) references form_topic(subtopic_id)
);

insert into jobs(job_id,job_name) 
    values 
        (1,'Chief'),
        (2,'Manager'),
        (3,'Officer');

insert into departments(dept_id,dept_name) 
    values 
        (1,'IT'),
        (2,'HR'),
        (3,'Financial'),
        (4,'Marketing');

insert into employees (e_id, firstname, lastname, salary, dept_id, job_id) 
    values 
        ('77024', 'Ernest', 'Mahoney', 52420, 1, 2),
        ('70618', 'Carly', 'Conrad', 33737, 4, 3),
        ('10613', 'Collin', 'Marquez', 30648, 4, 3),
        ('05269', 'Katherine', 'Newman', 80210, 3, 1),
        ('03989', 'Ronald', 'Garcia', 69548, 1, 2),
        ('39340', 'Amy', 'Donovan', 82409, 2, 1),
        ('23746', 'Gerald', 'Marquez', 26457, 3, 3),
        ('06261', 'Mackenzie', 'Cook', 54811, 4, 2),
        ('84731', 'Jason', 'Williamson', 69355, 1, 2),
        ('28399', 'Tammy', 'Jones', 78458, 3, 1),
        ('00000', 'Thanachote','Keakwanwong', 25000, 1,3),
        ('11111', 'Akarawit','Juntarang', 100000, 1,1),
        ('22222', 'Prompoj','Kongmanakiattikun', 50000,2,2);