# Install script for directory: /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/modules/video

# Set the install prefix
IF(NOT DEFINED CMAKE_INSTALL_PREFIX)
  SET(CMAKE_INSTALL_PREFIX "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release")
ENDIF(NOT DEFINED CMAKE_INSTALL_PREFIX)
STRING(REGEX REPLACE "/$" "" CMAKE_INSTALL_PREFIX "${CMAKE_INSTALL_PREFIX}")

# Set the install configuration name.
IF(NOT DEFINED CMAKE_INSTALL_CONFIG_NAME)
  IF(BUILD_TYPE)
    STRING(REGEX REPLACE "^[^A-Za-z0-9_]+" ""
           CMAKE_INSTALL_CONFIG_NAME "${BUILD_TYPE}")
  ELSE(BUILD_TYPE)
    SET(CMAKE_INSTALL_CONFIG_NAME "RELEASE")
  ENDIF(BUILD_TYPE)
  MESSAGE(STATUS "Install configuration: \"${CMAKE_INSTALL_CONFIG_NAME}\"")
ENDIF(NOT DEFINED CMAKE_INSTALL_CONFIG_NAME)

# Set the component getting installed.
IF(NOT CMAKE_INSTALL_COMPONENT)
  IF(COMPONENT)
    MESSAGE(STATUS "Install component: \"${COMPONENT}\"")
    SET(CMAKE_INSTALL_COMPONENT "${COMPONENT}")
  ELSE(COMPONENT)
    SET(CMAKE_INSTALL_COMPONENT)
  ENDIF(COMPONENT)
ENDIF(NOT CMAKE_INSTALL_COMPONENT)

# Install shared libraries without execute permission?
IF(NOT DEFINED CMAKE_INSTALL_SO_NO_EXE)
  SET(CMAKE_INSTALL_SO_NO_EXE "1")
ENDIF(NOT DEFINED CMAKE_INSTALL_SO_NO_EXE)

IF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")
  FOREACH(file
      "$ENV{DESTDIR}${CMAKE_INSTALL_PREFIX}/lib/libopencv_video.so.2.4.2"
      "$ENV{DESTDIR}${CMAKE_INSTALL_PREFIX}/lib/libopencv_video.so.2.4"
      "$ENV{DESTDIR}${CMAKE_INSTALL_PREFIX}/lib/libopencv_video.so"
      )
    IF(EXISTS "${file}" AND
       NOT IS_SYMLINK "${file}")
      FILE(RPATH_CHECK
           FILE "${file}"
           RPATH "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/lib")
    ENDIF()
  ENDFOREACH()
  FILE(INSTALL DESTINATION "${CMAKE_INSTALL_PREFIX}/lib" TYPE SHARED_LIBRARY FILES
    "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/lib/libopencv_video.so.2.4.2"
    "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/lib/libopencv_video.so.2.4"
    "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/lib/libopencv_video.so"
    )
  FOREACH(file
      "$ENV{DESTDIR}${CMAKE_INSTALL_PREFIX}/lib/libopencv_video.so.2.4.2"
      "$ENV{DESTDIR}${CMAKE_INSTALL_PREFIX}/lib/libopencv_video.so.2.4"
      "$ENV{DESTDIR}${CMAKE_INSTALL_PREFIX}/lib/libopencv_video.so"
      )
    IF(EXISTS "${file}" AND
       NOT IS_SYMLINK "${file}")
      FILE(RPATH_CHANGE
           FILE "${file}"
           OLD_RPATH "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/lib:"
           NEW_RPATH "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/lib")
      IF(CMAKE_INSTALL_DO_STRIP)
        EXECUTE_PROCESS(COMMAND "/usr/bin/strip" "${file}")
      ENDIF(CMAKE_INSTALL_DO_STRIP)
    ENDIF()
  ENDFOREACH()
ENDIF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")

IF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")
  FILE(INSTALL DESTINATION "${CMAKE_INSTALL_PREFIX}/include/opencv2/video" TYPE FILE FILES "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/modules/video/include/opencv2/video/background_segm.hpp")
ENDIF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")

IF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")
  FILE(INSTALL DESTINATION "${CMAKE_INSTALL_PREFIX}/include/opencv2/video" TYPE FILE FILES "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/modules/video/include/opencv2/video/tracking.hpp")
ENDIF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")

IF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")
  FILE(INSTALL DESTINATION "${CMAKE_INSTALL_PREFIX}/include/opencv2/video" TYPE FILE FILES "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/modules/video/include/opencv2/video/video.hpp")
ENDIF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")

