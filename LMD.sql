select * from employees;
select last_name as "nom de l'employees",first_name as "prenom de l'employess",date as "hire_date";
select 'le nom et le prenom' || first_name || ' '|| last_name as "nom et prenom" from employess order by date;
select * from employees date_embauche where date_embauche between to_date('1990-01-01', 'YYYY-MM-DD') and to_date('1990-12-31', 'YYYY-MM-DD');
select * from employees where (salary>2800);
select * from employees where department in (10,30,50);


select *from employees where ( salary in (4000,6000) and department in(20));
select *from employees where (commission_pct is NULL );
SELECT first_name, last_name, commission_pct FROM employees WHERE last_name LIKE 'A%';
SELECT first_name, last_name, commission_pct FROM employees WHERE first_name LIKE '%s%';
SELECT first_name, last_name, commission_pct FROM employees WHERE last_name LIKE '_i%';
SELECT first_name, last_name, hire_date FROM employees WHERE (hire_date > TO_DATE('01-01-1986', 'DD-MM-YYYY'))and(hire_date < TO_DATE('31-12-1990', 'DD-MM-YYYY'));
SELECT first_name, last_name, commission_pct FROM employees WHERE last_name LIKE '_i%';