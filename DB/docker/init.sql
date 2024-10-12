create table jobs (
    job_id INTEGER primary key,
    job_name varchar(100) not null
);

create table departments (
    dept_id INTEGER primary key,
    dept_name varchar(100) not null
);

create table form_appraisal (
    form_id serial primary key, 
    topic_id INTEGER not null,
    evalutor_id varchar(5) not null,
    evaluatee_id varchar(5) not null
);

create table form_topic (
    topic_id INTEGER primary key,
    topic_name varchar(50) not null,
    subtopic_id INTEGER not null
);

create table form_subtopic (
    subtopic_id INTEGER primary key,
    subtopic_name varchar(50) not null,
    scores INTEGER 
);

create table employees (
    e_id varchar(5) primary key,
    firstname varchar(100),
    lastname varchar(100),
    hire_date timestamp with time zone default current_timestamp,
    salary INTEGER,
    dept_id INTEGER not null,
    job_id INTEGER not null
);

alter table form_topic
add constraint fk_topic_id foreign key (topic_id) references form_appraisal(topic_id);

alter table form_subtopic
add constraint fk_subtopic_id foreign key (subtopic_id) references form_topic(subtopic_id);

alter table employees
add constraint fk_dept_id foreign key (dept_id) references departments(dept_id);

alter table employees
add constraint fk_jobs_id foreign key (job_id) references jobs(job_id);

insert into jobs(job_id,job_name) values (1,'Chief');
insert into jobs(job_id,job_name) values (2,'Manager');
insert into jobs(job_id,job_name) values (3,'Officer');

insert into departments(dept_id,dept_name) values (1,'IT');
insert into departments(dept_id,dept_name) values (2,'HR');
insert into departments(dept_id,dept_name) values (3,'Financial');
insert into departments(dept_id,dept_name) values (4,'Marketing');