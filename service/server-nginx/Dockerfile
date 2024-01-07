FROM nginx:1

#install applications
RUN apt-get -y update
RUN apt-get -y install openssl
RUN apt-get -y install nano

#fix terminal wrapping
COPY service/common/etc/.bashrc /tmp/
RUN cat /tmp/.bashrc >> /root/.bashrc

#prepare nginx
RUN rm /etc/nginx/conf.d/default.conf
COPY service/server-nginx/etc/ /etc/nginx/conf.d/
