FROM mysql:8-debian

#install applications
RUN apt-get -y update
RUN apt-get -y install nano

#fix terminal wrapping
COPY service/common/etc/.bashrc /tmp/
RUN cat /tmp/.bashrc >> /root/.bashrc

#prepare mysql
COPY service/server-mysql/etc/my.cnf /tmp/
RUN cat /tmp/my.cnf >> /etc/mysql/my.cnf
RUN mkdir -m 777 -p /var/log/mysql
