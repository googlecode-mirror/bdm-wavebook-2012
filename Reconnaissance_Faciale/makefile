CC=g++
VPATH=include:src:objects:lib:bin
OBJECTS=$(patsubst src/%.cpp,%.o,$(wildcard src/*.cpp))
OBJECTS_DIR=$(patsubst src/%.cpp,objects/%.o,$(wildcard src/*.cpp))

OPENCV_DIR=OpenCV-2.4.2


CFLAGS=-Wall -g
LFLAGS=-L ${OPENCV_DIR}/release/lib/ `pkg-config opencv --libs` -Llib/ 
IFLAGS=-I ${OPENCV_DIR}/include/ -I include/ \
	-I ${OPENCV_DIR}/modules/core/include \
	-I ${OPENCV_DIR}/modules/imgproc/include \
	-I ${OPENCV_DIR}/modules/video/include \
	-I ${OPENCV_DIR}/modules/features2d/include \
	-I ${OPENCV_DIR}/modules/androidcamera/include \
	-I ${OPENCV_DIR}/modules/flann/include \
	-I ${OPENCV_DIR}/modules/java/include \
	-I ${OPENCV_DIR}/modules/objdetect/include \
	-I ${OPENCV_DIR}/modules/python/include \
	-I ${OPENCV_DIR}/modules/calib3d/include \
	-I ${OPENCV_DIR}/modules/gpu/include \
	-I ${OPENCV_DIR}/modules/ml/include \
	-I ${OPENCV_DIR}/modules/legacy/include \
	-I ${OPENCV_DIR}/modules/nonfree/include \
	-I ${OPENCV_DIR}/modules/world/include \
	-I ${OPENCV_DIR}/modules/photo/include \
	-I ${OPENCV_DIR}/modules/ts/include \
	-I ${OPENCV_DIR}/modules/contrib/include \
	-I ${OPENCV_DIR}/modules/highgui/include 


# if looking for library flags, try command "${libname}-config --ldflags"
# or "pkg-config ${libname} --libs"

all : main

main : $(OBJECTS)
	export PKG_CONFIG_PATH=${OPENCV_DIR}/unix-install/
	$(CC) $(CFLAGS) $(IFLAGS) $(OBJECTS_DIR) $(LFLAGS) -o $@
	mv $@ bin/

run : main
	export LD_LIBRARY_PATH="${LD_LIBRARY_PATH}:${OPENCV_DIR}/release/lib/" 
	bin/main


%.o : %.cpp
	export PKG_CONFIG_PATH=${OPENCV_DIR}/unix-install/
	$(CC) $(CFLAGS) $(IFLAGS) $(LFGLAGS) -c $<
	mv $@ objects/

archive : 
	tar -cvf archive.tar makefile src/*.cpp include/*.h include/*.hpp
	gzip archive.tar

TAGS : 
	find . -type f -iname "*.h" -or -iname "*.cpp" -or -iname "*.hpp" | xargs etags -a 

clean :
	rm -f objects/*.o bin/main src/*~ include/*~
