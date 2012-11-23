CC=g++
OBJECTS=$(patsubst src/%.cpp,%.o,$(wildcard src/*.cpp))
OBJECTS_DIR=$(patsubst src/%.cpp,objects/%.o,$(wildcard src/*.cpp))

OPENCV_DIR=./OpenCV-2.4.2
OPENCV_PKG_PATH=${OPENCV_DIR}
OPENCV_RELEASE_DIR=${OPENCV_DIR}/release
OPENCV_LIB_PATH=${OPENCV_RELEASE_DIR}/lib

# path where dependencies are searched
VPATH=include:src:objects:lib:bin:${OPENCV_LIB_PATH}

# set of environment variable (care colon when assign)
export PKG_CONFIG_PATH:=${PKG_CONFIG_PATH}:${OPENCV_PKG_PATH}
export LD_LIBRARY_PATH:=${LD_LIBRARY_PATH}:${OPENCV_LIB_PATH}

OPENCV_ONE_LIB_NAME=libopencv_contrib.so

CFLAGS=-Wall -g
LFLAGS=-L ${OPENCV_LIB_PATH} `pkg-config opencv --libs` -Llib/ 
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

main : $(OBJECTS) ${OPENCV_ONE_LIB_NAME}
	$(CC) $(CFLAGS) $(IFLAGS) $(OBJECTS_DIR) $(LFLAGS) -o $@
	mv $@ bin/

# build openCV libs
${OPENCV_ONE_LIB_NAME} :
	echo $@
	cd ${OPENCV_RELEASE_DIR}; \
	cmake -D CMAKE_BUILD_TYPE=RELEASE -D CMAKE_INSTALL_PREFIX=. -D BUILD_PYTHON_SUPPORT=ON -D BUILD_EXAMPLES=OFF BUILD_DOCS=OFF .. ;\
	make

run : main
	bin/main $(ARG) $(IMG) $(ID)
	 
	
%.o : %.cpp
	$(CC) $(CFLAGS) $(IFLAGS) $(LFGLAGS) -c $<
	mv $@ objects/

archive : 
	tar -cvf archive.tar makefile src/*.cpp include/*.h include/*.hpp
	gzip archive.tar

TAGS : 
	find . -type f -iname "*.h" -or -iname "*.cpp" -or -iname "*.hpp" | xargs etags -a 

clean :
	rm -rf objects/*.o bin/main src/*~ include/*~ 
